<?php

namespace App\Controller;

use App\Entity\StockRequestItems;
use App\Form\StockRequestItemsType;
use App\Repository\StockRequestItemsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/stock/request/items')]
final class StockRequestItemsController extends AbstractController
{
    #[Route(name: 'app_stock_request_items_index', methods: ['GET'])]
    public function index(StockRequestItemsRepository $stockRequestItemsRepository): Response
    {
        return $this->render('stock_request_items/index.html.twig', [
            'stock_request_items' => $stockRequestItemsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_stock_request_items_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stockRequestItem = new StockRequestItems();
        $form = $this->createForm(StockRequestItemsType::class, $stockRequestItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stockRequestItem);
            $entityManager->flush();

            return $this->redirectToRoute('app_stock_request_items_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stock_request_items/new.html.twig', [
            'stock_request_item' => $stockRequestItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_request_items_show', methods: ['GET'])]
    public function show(StockRequestItems $stockRequestItem): Response
    {
        return $this->render('stock_request_items/show.html.twig', [
            'stock_request_item' => $stockRequestItem,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stock_request_items_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StockRequestItems $stockRequestItem, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StockRequestItemsType::class, $stockRequestItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stock_request_items_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stock_request_items/edit.html.twig', [
            'stock_request_item' => $stockRequestItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_request_items_delete', methods: ['POST'])]
    public function delete(Request $request, StockRequestItems $stockRequestItem, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stockRequestItem->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($stockRequestItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stock_request_items_index', [], Response::HTTP_SEE_OTHER);
    }
}
