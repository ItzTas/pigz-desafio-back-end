<?php

namespace App\Controller\Users;

use App\MiddlewareInterfaces\TokenAuthenticatedControler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class UserAutenticatedController extends AbstractController implements TokenAuthenticatedControler
{
    #[Route('/users', name: 'create_user', methods: ['POST'])]
    public function createUser(): JsonResponse
    {
        return $this->json([]);
    }
}
