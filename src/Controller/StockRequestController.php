<?php

namespace App\Controller;

use App\Entity\Sites;
use App\Entity\StockRequest;
use App\Entity\StockRequestItems;
use App\Form\StockRequestItemsType;
use App\Form\StockRequestType;
use App\Repository\StockRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Workflow\Registry;

#[Route('/stock/request')]
#[isGranted('IS_AUTHENTICATED_REMEMBERED')]
final class StockRequestController extends AbstractController
{
    public function __construct(private PaginatorInterface $paginator ) {
    }
    #[Route(name: 'app_stock_request_index', methods: ['GET'])]
    public function index(StockRequestRepository $stockRequestRepository, Request $request): Response
    {
        $queryBuilder = $stockRequestRepository->createActiveStockRequestsQueryBuilder();

        $paginator = $this->paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10),
            [
                'pageRange' => 3
            ]
        );

        return $this->render('stock_request/index.html.twig', [
            'stock_requests' => $paginator
        ]);
    }

    #[Route('/new', name: 'app_stock_request_new', methods: ['GET', 'POST'])]
    public function new(
        Request                $request,
        EntityManagerInterface $entityManager,
        StockRequestRepository $stockRequestRepository
    ): Response
    {
        $draft = $stockRequestRepository->getDraftStockRequestIdByUser();

        if ($draft) {
            return $this->redirectToRoute('app_stock_request_edit', ['id' => $draft]);
        }

        $stockRequest = new StockRequest();
        $form = $this->createForm(StockRequestType::class, $stockRequest);

        //set default values to stock request
        $headquarterSite = $entityManager->getRepository(Sites::class)->findOneBy(['name' => 'Headquarters']);
        $stockRequest->setRequestedBy($this->getUser());
        $stockRequest->setToSite($this->getUser()->getSite());
        $stockRequest->setFromSite($headquarterSite);
        $form->setData($stockRequest);

        $form->handleRequest($request);
        $entityManager->persist($stockRequest);
        $entityManager->flush();

        // redirect to edit page
        return $this->redirectToRoute('app_stock_request_edit', ['id' => $stockRequest->getId()]);
    }

    #[Route('/{id}', name: 'app_stock_request_show', methods: ['GET'])]
    public function show(StockRequest $stockRequest): Response
    {
        //access control
        $this->denyAccessUnlessGranted('VIEW', $stockRequest);
        return $this->render('stock_request/show.html.twig', [
            'stock_request' => $stockRequest,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stock_request_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request                $request,
        StockRequest           $stockRequest,
        EntityManagerInterface $entityManager,
        Registry               $workflowRegistry
    ): Response
    {
        // Access control
        $this->denyAccessUnlessGranted('EDIT', $stockRequest);

        // Stock request form
        $isStockRequestReviewer = $this->isGranted('EDIT', $stockRequest);
        $stockRequestForm = $this->createForm(StockRequestType::class, $stockRequest, [
            'editable' => $isStockRequestReviewer,
        ]);

        // Stock request item form
        $stockRequestItem = new StockRequestItems();
        $stockRequestItemForm = $this->createForm(StockRequestItemsType::class, $stockRequestItem, [
            'stock_request' => $stockRequest
        ]);
        $stockRequestItemForm
            ->remove('stockRequest')
            ->remove('quantity_approved')
            ->remove('status');

        // Handle both forms
        $stockRequestForm->handleRequest($request);
        $stockRequestItemForm->handleRequest($request);

        // Get available transitions
        $workflow = $workflowRegistry->get($stockRequest, 'stock_request_approval');
        $availableTransitions = $workflow->getEnabledTransitions($stockRequest);

        if ($stockRequestForm->isSubmitted() && $stockRequestForm->isValid()) {
            $entityManager->flush();

            // Redirect to index
            return $this->redirectToRoute('app_stock_request_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($stockRequestItemForm->isSubmitted() && $stockRequestItemForm->isValid()) {
            $stockRequest->addStockRequestItem($stockRequestItem);
            $entityManager->persist($stockRequestItem);
            $entityManager->flush();

            // Redirect to self
            return $this->redirectToRoute('app_stock_request_edit', ['id' => $stockRequest->getId()]);
        }
        return $this->render('stock_request/edit.html.twig', [
            'stock_request' => $stockRequest,
            'stock_request_form' => $stockRequestForm->createView(),
            'stock_request_items_form' => $stockRequestItemForm->createView(),
            'transitions' => $availableTransitions,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_request_delete', methods: ['POST'])]
    public function delete(
        Request                $request,
        StockRequest           $stockRequest,
        EntityManagerInterface $entityManager
    ): Response
    {
        $this->denyAccessUnlessGranted('DELETE', $stockRequest);
        if ($this->isCsrfTokenValid('delete' . $stockRequest->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($stockRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stock_request_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/transition/{transition}', name: 'app_stock_request_transition', methods: ['GET'])]
    public function transition(
        string                 $transition,
        Request                $request,
        StockRequest           $stockRequest,
        Registry               $workflowRegistry,
        EntityManagerInterface $entityManager
    ): Response
    {
        $this->denyAccessUnlessGranted('EDIT', $stockRequest);

        $token = $request->query->get('_token');
        if (!$this->isCsrfTokenValid('transition_' . $transition, $token)) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        $workflow = $workflowRegistry->get($stockRequest, 'stock_request_approval');

        $canApply = $workflow->can($stockRequest, $transition);
        if ($canApply) {

            $workflow->apply($stockRequest, $transition);
            $message = "Transition '$transition' applied successfully.";
        } elseif ($this->isGranted('ROLE_ADMIN')) {
            $stockRequest->setStatus($transition);
            $message = "Admin override: status of stock request ID " . $stockRequest->getId() . " moved directly to '$transition'.";
        } else {
            $this->addFlash('error', "Transition '$transition' is not allowed.");
            return $this->redirectToRoute('app_stock_request_index');
        }
        if ($transition != 'draft') {
            $stockRequest->setApprovedBy($this->getUser());
        }
        $entityManager->flush();
        $this->addFlash('success', $message);

        return $this->redirectToRoute('app_stock_request_index');
    }
}
