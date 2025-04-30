<?php

namespace App\Controller;

use App\Entity\Sites;
use App\Entity\StockRequest;
use App\Enum\Stock\StockRequestStatus;
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
            'stock_requests' => $stockRequestRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_stock_request_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stockRequest = new StockRequest();
        $form = $this->createForm(StockRequestType::class, $stockRequest);

        $stockRequest->setRequestedBy($this->getUser());
        $stockRequest->setToSite($this->getUser()->getSite());
        $headquarterSite = $entityManager->getRepository(Sites::class)
            ->findOneBy(['id' => 1]);
        $stockRequest->setFromSite($headquarterSite);
        $stockRequest->setStatus(StockRequestStatus::PENDING);
//        dd($stockRequest);
        $form->setData($stockRequest);
        $form->handleRequest($request);

        $entityManager->persist($stockRequest);
        $entityManager->flush();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stockRequest);
            $entityManager->flush();

            return $this->redirectToRoute('app_stock_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stock_request/new.html.twig', [
            'stock_request' => $stockRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_request_show', methods: ['GET'])]
    public function show(StockRequest $stockRequest): Response
    {
        return $this->render('stock_request/show.html.twig', [
            'stock_request' => $stockRequest,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stock_request_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StockRequest $stockRequest, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StockRequestType::class, $stockRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stock_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stock_request/edit.html.twig', [
            'stock_request' => $stockRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_request_delete', methods: ['POST'])]
    public function delete(Request $request, StockRequest $stockRequest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stockRequest->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($stockRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stock_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
