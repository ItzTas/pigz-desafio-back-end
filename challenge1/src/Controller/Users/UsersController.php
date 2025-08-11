<?php

namespace App\Controller\Users;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class UsersController extends AbstractController
{
    #[Route('/register', name: 'register_user', methods: ['POST'])]
    public function registerUser(): JsonResponse
    {
        return $this->json([]);
    }
}
