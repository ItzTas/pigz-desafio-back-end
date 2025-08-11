<?php

namespace App\Controller;

use App\MiddlewareInterfaces\TokenAuthenticatedControler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class UsersController extends AbstractController implements TokenAuthenticatedControler
{
    #[Route('/login', name: 'login', methods: ['POST'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UsersController.php',
        ]);
    }

    #[Route('/login/superuser', name: 'get_superuser', methods: ['GET'])]
    public function superUser(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UsersController.php',
        ]);
    }

    #[Route('/users', name: 'create_user', methods: ['POST'])]
    public function createUser(): JsonResponse
    {
        return $this->json([]);
    }
}
