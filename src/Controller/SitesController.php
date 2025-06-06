<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SitesType;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/sites')]
#[IsGranted('ROLE_SITE_CRUD')]
final class SitesController extends AbstractController
{
    #[Route(name: 'app_sites_index', methods: ['GET'])]
    public function index(SiteRepository $sitesRepository): Response
    {
        return $this->render('sites/index.html.twig', [
            'sites' => $sitesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sites_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SITE_CRUD');
        $site = new Site();
        $form = $this->createForm(SitesType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($site);
            $entityManager->flush();

            return $this->redirectToRoute('app_sites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sites/new.html.twig', [
            'site' => $site,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sites_show', methods: ['GET'])]
    public function show(Site $site): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SITE_CRUD');
        return $this->render('sites/show.html.twig', [
            'site' => $site,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sites_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Site $site, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SITE_CRUD');
        $form = $this->createForm(SitesType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sites/edit.html.twig', [
            'site' => $site,
            'form' => $form,
        ]);
    }
}
