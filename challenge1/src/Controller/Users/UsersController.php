<?php

namespace App\Controller\Users;

use App\DTO\LoginDTO;
use App\DTO\SerializableUser;
use App\Repository\UserRepository;
use App\Service\TokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class UsersController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private TokenService $tokenService,
        private UserPasswordHasherInterface $passwordHasher,
    ) {}

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(
        #[MapRequestPayload] LoginDTO $data,
    ): JsonResponse {
        $user = $this->userRepository->findUserByEmail($data->getEmail());
        if ($user === null) {
            throw new UnauthorizedHttpException("Invalid password or email");
        }

        if (!$this->passwordHasher->isPasswordValid($user, $data->password)) {
            throw new UnauthorizedHttpException("Invalid password or email");
        }

        $token = $this->tokenService->encode($user->getId());

        return $this->json([
            'user' => new SerializableUser($user),
            'token' => $token,
        ]);
    }
}
