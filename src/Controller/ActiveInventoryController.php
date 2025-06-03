<?php

namespace App\Controller;

use App\Entity\ActiveInventory;
use App\Form\ActiveInventoryForm;
use App\Repository\ActiveInventoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/inventory/active')]
final class ActiveInventoryController extends AbstractController
{
    #[Route(name: 'app_inventory_active_index', methods: ['GET'])]
    public function index(ActiveInventoryRepository $activeInventoryRepository): Response
    {
        return $this->render('active_inventory/index.html.twig', [
            'active_inventories' => $activeInventoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_inventory_active_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $activeInventory = new ActiveInventory();
        $form = $this->createForm(ActiveInventoryForm::class, $activeInventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($activeInventory);
            $entityManager->flush();

            return $this->redirectToRoute('app_inventory_active_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('active_inventory/new.html.twig', [
            'active_inventory' => $activeInventory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inventory_active_show', methods: ['GET'])]
    public function show(ActiveInventory $activeInventory): Response
    {
        return $this->render('active_inventory/show.html.twig', [
            'active_inventory' => $activeInventory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_inventory_active_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ActiveInventory $activeInventory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActiveInventoryForm::class, $activeInventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_inventory_active_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('active_inventory/edit.html.twig', [
            'active_inventory' => $activeInventory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inventory_active_delete', methods: ['POST'])]
    public function delete(Request $request, ActiveInventory $activeInventory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activeInventory->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($activeInventory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_inventory_active_index', [], Response::HTTP_SEE_OTHER);
    }
}
