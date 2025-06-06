<?php

namespace App\Controller;

use App\Entity\StockMovement;
use App\Entity\StockMovementItem;
use App\Entity\StockRequest;
use App\Enum\StockRequestItemsStatus;
use App\Form\StockMovementForm;
use App\Form\StockMovementItemForm;
use App\Repository\StockMovementRepository;
use App\Repository\StockRequestItemRepository;
use App\Repository\StockRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/stock-movement')]
final class StockMovementController extends AbstractController
{
    #[Route(name: 'app_stock_movement_index', methods: ['GET'])]
    public function index(StockMovementRepository $stockMovementRepository): Response
    {
        return $this->render('stock_movement/index.html.twig', [
            'stock_movements' => $stockMovementRepository->findAll(),
        ]);
    }

    #[Route('/{id}/initiate', name: 'app_stock_movement_initiate', methods: ['GET', 'POST'])]
    public function new(
        StockRequest            $stockRequest,
        Request                 $request,
        EntityManagerInterface  $entityManager,
        StockRequestRepository  $stockRequestRepository,
        StockMovementRepository $stockMovementRepository
    ): Response
    {
        if ($stockRequest->getStatus() != 'approved') {
            $this->addFlash('error', "Stock Request :- " . $stockRequest->getId() . " is not currently approved.");
            return $this->redirectToRoute('app_stock_request_show', [
                'id' => $stockRequest->getId(),
            ], Response::HTTP_SEE_OTHER);
        }
        $stockMovement = $stockMovementRepository->findOneBy([
            'stockRequest' => $stockRequest,
            'status' => 'draft',
        ]);
        if (!$stockMovement) {
            $stockMovement = new  StockMovement();
            $this->addFlash('success', "Stock Movement For Request :- " . $stockRequest->getId() . " is Initiated.");
        }
        $stockMovement->setStockRequest($stockRequest);
        $stockMovement->setStatus('draft');
        $entityManager->persist($stockMovement);
        $entityManager->flush();


        return $this->redirectToRoute('app_stock_movement_edit', ['id' => $stockMovement->getId()]);

    }

    #[Route('/{id}', name: 'app_stock_movement_show', methods: ['GET'])]
    public function show(StockMovement $stockMovement): Response
    {
        return $this->render('stock_movement/show.html.twig', [
            'stock_movement' => $stockMovement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stock_movement_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request                $request,
        StockMovement          $stockMovement,
        EntityManagerInterface $entityManager,
        StockRequestItemRepository  $stockRequestItemRepository,
    ): Response
    {
        //Stock Movement Form
        $stockMovementForm = $this->createForm(StockMovementForm::class, $stockMovement);

        //Stock Movement Items Form
        $stockMovementItem = new StockMovementItem();

        $stockMovementItemForm = $this->createForm(StockMovementItemForm::class, $stockMovementItem, [
            'stockRequest' => $stockMovement->getStockRequest(),
        ]);

        //Handle both form
        $stockMovementForm->handleRequest($request);
        $stockMovementItemForm->handleRequest($request);

        if ($stockMovementForm->isSubmitted() && $stockMovementForm->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stock_movement_edit', [
                'id' => $stockMovement->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        if ($stockMovementItemForm->isSubmitted() && $stockMovementItemForm->isValid()) {
            $stockMovement->addStockMovementItem($stockMovementItem);
            $entityManager->persist($stockMovementItem);
            $entityManager->flush();

            // Redirect to self
            return $this->redirectToRoute('app_stock_movement_edit', [
                'id' => $stockMovement->getId()
            ]);
        }

        $approvedStockRequestItems = $stockRequestItemRepository->findBy([
            'stockRequest' => $stockMovement->getStockRequest(),
            'status' => StockRequestItemsStatus::Approved,
        ]);

        return $this->render('stock_movement/edit.html.twig', [
            'stock_movement' => $stockMovement,
            'form' => $stockMovementForm,
            'stock_movement_item_form' => $stockMovementItemForm,
            'approved_stock_request_items' => $approvedStockRequestItems,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_movement_delete', methods: ['POST'])]
    public function delete(Request $request, StockMovement $stockMovement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $stockMovement->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($stockMovement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stock_movement_index', [], Response::HTTP_SEE_OTHER);
    }
}
