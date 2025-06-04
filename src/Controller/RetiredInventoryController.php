<?php

namespace App\Controller;

use App\Entity\RetiredInventory;
use App\Form\RetiredInventoryForm;
use App\Repository\RetiredInventoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/inventory/retired')]
#[isGranted('ROLE_USER')]
final class RetiredInventoryController extends BaseController
{
    #[Route(name: 'app_inventory_retired_index', methods: ['GET'])]
    public function index(RetiredInventoryRepository $retiredInventoryRepository): Response
    {
        return $this->render('retired_inventory/index.html.twig', [
            'retired_inventories' => $retiredInventoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_inventory_retired_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $retiredInventory = new RetiredInventory();
        $form = $this->createForm(RetiredInventoryForm::class, $retiredInventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($retiredInventory);
            $entityManager->flush();

            return $this->redirectToRoute('app_inventory_retired_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('retired_inventory/new.html.twig', [
            'retired_inventory' => $retiredInventory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inventory_retired_show', methods: ['GET'])]
    public function show(RetiredInventory $retiredInventory): Response
    {
        return $this->render('retired_inventory/show.html.twig', [
            'retired_inventory' => $retiredInventory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_inventory_retired_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RetiredInventory $retiredInventory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RetiredInventoryForm::class, $retiredInventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_inventory_retired_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('retired_inventory/edit.html.twig', [
            'retired_inventory' => $retiredInventory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inventory_retired_delete', methods: ['POST'])]
    public function delete(Request $request, RetiredInventory $retiredInventory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$retiredInventory->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($retiredInventory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_inventory_retired_index', [], Response::HTTP_SEE_OTHER);
    }
}
