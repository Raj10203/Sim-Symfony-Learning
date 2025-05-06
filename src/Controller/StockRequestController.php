<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Sites;
use App\Entity\StockRequest;
use App\Entity\StockRequestItems;
use App\Enum\Stock\StockRequestStatus;
use App\Form\ProductsType;
use App\Form\StockRequestItemsType;
use App\Form\StockRequestType;
use App\Repository\StockRequestItemsRepository;
use App\Repository\StockRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    #[Route(name: 'app_stock_request_index', methods: ['GET'])]
    public function index(StockRequestRepository $stockRequestRepository): Response
    {
        return $this->render('stock_request/index.html.twig', [
            'stock_requests' => $stockRequestRepository->getActiveStockRequests()
        ]);
    }

    #[Route('/new', name: 'app_stock_request_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, StockRequestRepository $stockRequestRepository): Response
    {
        $draft = $stockRequestRepository->getDraftStockRequestIdByUser();

        if ($draft) {
            return $this->redirectToRoute('app_stock_request_edit', ['id' => $draft]);
        }
        $stockRequest = new StockRequest();
        $form = $this->createForm(StockRequestType::class, $stockRequest);

        //set default values to stock request
        $headquarterSite = $entityManager->getRepository(Sites::class)->findOneBy(['id' => 1]);
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
    public function edit(Request                     $request, StockRequest $stockRequest, EntityManagerInterface $entityManager,
                         StockRequestItemsRepository $stockRequestItemsRepository, Registry $workflowRegistry): Response
    {
        // Access control
        $this->denyAccessUnlessGranted('EDIT', $stockRequest);

        // Stock request form
        $isStockRequestReviewer = $this->isGranted('ROLE_STOCK_REQUEST_REVIEWER');
        $stockRequestForm = $this->createForm(StockRequestType::class, $stockRequest, [
            'isStockRequestReviewer' => $isStockRequestReviewer,
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
            $stockRequestItem->setStockRequest($stockRequest);
            $entityManager->persist($stockRequestItem);
            $entityManager->flush();

            // Redirect to self
            return $this->redirectToRoute('app_stock_request_edit', ['id' => $stockRequest->getId()]);
        }

        return $this->render('stock_request/edit.html.twig', [
            'stock_request' => $stockRequest,
            'stock_request_form' => $stockRequestForm->createView(),
            'stock_request_items_form' => $stockRequestItemForm->createView(),
            'stock_request_items' => $stockRequestItemsRepository->findBy(['stockRequest' => $stockRequest]),
            'transitions' => $availableTransitions,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_request_delete', methods: ['POST'])]
    public function delete(Request $request, StockRequest $stockRequest, EntityManagerInterface $entityManager): Response
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
        string $transition,
        Request $request,
        StockRequest $stockRequest,
        Registry $workflowRegistry,
        EntityManagerInterface $entityManager
    ): Response {
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
            // Admin override: set the state directly
            $reflection = new \ReflectionObject($stockRequest);
            $property = $reflection->getProperty('status');
            $property->setAccessible(true);
            $property->setValue($stockRequest, $transition);
            $message = "Admin override: moved directly to '$transition'.";
        } else {
            $this->addFlash('error', "Transition '$transition' is not allowed.");
            return $this->redirectToRoute('app_stock_request_edit', ['id' => $stockRequest->getId()]);
        }

        $entityManager->flush();
        $this->addFlash('success', $message);

        return $this->redirectToRoute('app_stock_request_edit', ['id' => $stockRequest->getId()]);
    }
}
