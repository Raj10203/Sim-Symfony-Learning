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
        $stockRequest->setStatus(StockRequestStatus::Draft);
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
    public function edit(Request $request, StockRequest $stockRequest, EntityManagerInterface $entityManager,
                         StockRequestItemsRepository $stockRequestItemsRepository, Registry $workflowRegistry): Response
    {
        //access control
        $this->denyAccessUnlessGranted('EDIT', $stockRequest);

        // stock request form
        $isStockRequestReviewer = $this->isGranted('ROLE_STOCK_REQUEST_REVIEWER');
        $stockRequestForm = $this->createForm(StockRequestType::class, $stockRequest, [
            'isStockRequestReviewer' => $isStockRequestReviewer,
        ]);

        // stock request's form
        $stockRequestItem = new StockRequestItems();
        $stockRequestItemForm = $this->createForm(StockRequestItemsType::class, $stockRequestItem, [
            'stock_request' => $stockRequest
        ]);
        $stockRequestItemForm
            ->remove('stockRequest')
            ->remove('quantity_approved')
            ->remove('status');

        if (!$this->isGranted('ROLE_STOCK_REQUEST_REVIEWER')) {
            $stockRequestForm->remove('status');
        }
        //handle both form
        $stockRequestForm->handleRequest($request);
        $stockRequestItemForm->handleRequest($request);

        if ($stockRequestForm->isSubmitted() && $stockRequestForm->isValid()) {
            $workflow = $workflowRegistry->get($stockRequest, 'stock_request_approval');

            if ($isStockRequestReviewer) {
                $targetStatus = $stockRequestForm->get('status')->getData();
                if ($workflow->can($stockRequest, $targetStatus)) {
                    $workflow->apply($stockRequest, $targetStatus);
                } else {
                    $this->addFlash('error', "Invalid transition to $targetStatus.");
                }
            }

            $entityManager->flush();

            //redirect to index
            return $this->redirectToRoute('app_stock_request_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($stockRequestItemForm->isSubmitted() && $stockRequestItemForm->isValid()) {
            $stockRequestItem->setstockRequest($stockRequest);
            $entityManager->persist($stockRequestItem);
            $entityManager->flush();

            //redirect self
            return $this->redirectToRoute('app_stock_request_edit', ['id' => $stockRequest->getId()]);
        }

        return $this->render('stock_request/edit.html.twig', [
            'stock_request' => $stockRequest,
            'stock_request_form' => $stockRequestForm,
            'stock_request_items_form' => $stockRequestItemForm,
            'stock_request_items' => $stockRequestItemsRepository->findBy(['stockRequest' => $stockRequest]),
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
}
