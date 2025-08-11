<?php

namespace App\Controller\Users;

use ApiPlatform\Metadata\Exception\AccessDeniedException;
use App\Controller\TokenAuthenticatedControler;
use App\DTO\CreateUserDTO;
use App\Repository\UserRepository;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class UserAutenticatedController extends AbstractController implements TokenAuthenticatedControler
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private AuthService $authService,
    ) {}

    #[Route('/users', name: 'create_user', methods: ['POST'])]
    public function createUser(
        #[MapQueryParameter] CreateUserDTO $data,
        Request $req,
    ): JsonResponse {
        $authUser = $this->userRepository->findUserByRequestWithToken($req);
        if (!$this->authService->hasUserPermission('CREATE_USER', $authUser)) {
            throw new AccessDeniedException('User does not have permission for ');
        }

        return $this->json([]);
    }
}
