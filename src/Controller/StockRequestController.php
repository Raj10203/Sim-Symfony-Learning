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
use App\Repository\StockRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/stock/request')]
final class StockRequestController extends AbstractController
{
    #[Route(name: 'app_stock_request_index', methods: ['GET'])]
    public function index(StockRequestRepository $stockRequestRepository): Response
    {
        return $this->render('stock_request/index.html.twig', [
            'stock_requests' => $stockRequestRepository->getActiveStockRequests($this->getUser())
        ]);
    }

    #[Route('/new', name: 'app_stock_request_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, StockRequestRepository $stockRequestRepository): Response
    {
        $draft = $stockRequestRepository->getDraftStockRequestIdByUser($this->getUser()->getId());

        if($draft) {
           return $this->redirectToRoute('app_stock_request_edit',  ['id' => $draft]);
        }
        $stockRequest = new StockRequest();
        $product = new Products();
        $form = $this->createForm(StockRequestType::class, $stockRequest);
        $productForm = $this->createForm(ProductsType::class, $product);

        $stockRequest->setRequestedBy($this->getUser());
        $stockRequest->setToSite($this->getUser()->getSite());
        $headquarterSite = $entityManager->getRepository(Sites::class)->findOneBy(['id' => 1]);
        $stockRequest->setFromSite($headquarterSite);
        $stockRequest->setStatus(StockRequestStatus::Draft);
        $form->setData($stockRequest);
        $form->handleRequest($request);

        $entityManager->persist($stockRequest);
        $entityManager->flush();

        return $this->redirectToRoute('app_stock_request_edit', ['id' => $stockRequest->getId()]);
    }

    #[Route('/{id}', name: 'app_stock_request_show', methods: ['GET'])]
    public function show(StockRequest $stockRequest): Response
    {
        $this->denyAccessUnlessGranted('VIEW', $stockRequest);
        return $this->render('stock_request/show.html.twig', [
            'stock_request' => $stockRequest,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stock_request_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StockRequest $stockRequest, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('EDIT', $stockRequest);
        $stockRequestForm = $this->createForm(StockRequestType::class, $stockRequest);
        $stockRequestForm->handleRequest($request);
        $stockRequestItem = new StockRequestItems();

        $stockRequestItemForm = $this->createForm(StockRequestItemsType::class, $stockRequestItem);
        $stockRequestItemForm
            ->remove('requestedBy')
            ->remove('requestId')
            ->remove('quantity_approved')
            ->remove('status');
        $stockRequestItemForm->handleRequest($request);

        if ($stockRequestItemForm->isSubmitted() && $stockRequestItemForm->isValid()) {
            $entityManager->persist($stockRequestItem);
            $entityManager->flush();
        }

        if ($stockRequestForm->isSubmitted() && $stockRequestForm->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_stock_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stock_request/edit.html.twig', [
            'stock_request' => $stockRequest,
            'stockRequestForm' => $stockRequestForm ,
            'stockRequestItemsForm' => $stockRequestItemForm,
            'stockRequestItems' => $stockRequest->getStockRequestItems()
        ]);
    }

    #[Route('/{id}', name: 'app_stock_request_delete', methods: ['POST'])]
    public function delete(Request $request, StockRequest $stockRequest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $stockRequest->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($stockRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stock_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
