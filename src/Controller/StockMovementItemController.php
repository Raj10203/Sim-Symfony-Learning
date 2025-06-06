<?php

namespace App\Controller;

use App\Entity\StockMovementItem;
use App\Form\StockMovementItemForm;
use App\Repository\StockMovementItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/stock/movement/item')]
final class StockMovementItemController extends AbstractController
{
    #[Route(name: 'app_stock_movement_item_index', methods: ['GET'])]
    public function index(StockMovementItemRepository $stockMovementItemRepository): Response
    {
        return $this->render('stock_movement_item/index.html.twig', [
            'stock_movement_items' => $stockMovementItemRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_stock_movement_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stockMovementItem = new StockMovementItem();
        $form = $this->createForm(StockMovementItemForm::class, $stockMovementItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stockMovementItem);
            $entityManager->flush();

            return $this->redirectToRoute('app_stock_movement_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stock_movement_item/new.html.twig', [
            'stock_movement_item' => $stockMovementItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_movement_item_show', methods: ['GET'])]
    public function show(StockMovementItem $stockMovementItem): Response
    {
        return $this->render('stock_movement_item/show.html.twig', [
            'stock_movement_item' => $stockMovementItem,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stock_movement_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StockMovementItem $stockMovementItem, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StockMovementItemForm::class, $stockMovementItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stock_movement_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stock_movement_item/edit.html.twig', [
            'stock_movement_item' => $stockMovementItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_movement_item_delete', methods: ['POST'])]
    public function delete(Request $request, StockMovementItem $stockMovementItem, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stockMovementItem->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($stockMovementItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stock_movement_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
