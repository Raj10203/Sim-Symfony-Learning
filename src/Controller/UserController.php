<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/api/me', name: 'app_api_me')]
    #[isGranted('ROLE_USER')]
    public function apiMe(SerializerInterface $serializer): Response
    {
        $json = $serializer->serialize(
            $this->getUser(),
            'json',
            ['groups' => ['user:read', 'site:read']]
        );
        return new JsonResponse($json, 200, [], true);
    }
}
