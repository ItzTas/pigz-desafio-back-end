<?php

namespace App\Controller\Users;

use ApiPlatform\Metadata\Exception\AccessDeniedException;
use App\DTO\CreateUserDTO;
use App\DTO\RegisterPermissionDTO;
use App\DTO\SerializableUser;
use App\Entity\User;
use App\Repository\UserPermissionRepository;
use App\Repository\UserRepository;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class UserAutenticatedController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private AuthService $authService,
        private UserPermissionRepository $userPermissionRepository,
    ) {}

    #[Route('/users', name: 'create_user', methods: ['POST'])]
    public function createUser(
        #[MapRequestPayload] CreateUserDTO $data,
        Request $req,
    ): JsonResponse {
        $authUser = $this->userRepository->findUserByRequestWithToken($req);
        $authorized = $this->authService->hasUserPermission('CREATE_USER', $authUser);

        if (!$authorized) {
            throw new AccessDeniedException('User does not have permission for operation');
        }

        $user = $this->userRepository->findUserByEmail($data->email);
        if ($user !== null) {
            throw new BadRequestException('This email is already beeing used');
        }

        $user = new User()
            ->setEmail($data->email)
            ->setName($data->name);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $data->getPassword());
        $user->setPassword($hashedPassword);
        $this->userRepository->registerUserClass($user);

        return $this->json(new SerializableUser($user));
    }

    #[Route('/users/{<\id+>}/permission', name: 'register_permission', methods: ['POST'])]
    public function registerPermission(
        int $id,
        #[MapRequestPayload] RegisterPermissionDTO $data,
        Request $req,
    ) {
        $authUser = $this->userRepository->findUserByRequestWithToken($req);
        $authorized = $this->authService->hasUserPermission('GRANT_PERMISSION', $authUser);
        if (!$authorized) {
            throw new AccessDeniedException('User does not have permission for operation');
        }
        $user = $this->userRepository->findUserByID($id);
        if ($this->authService->hasUserPermission($data->permissionName, $user)) {
            throw new BadRequestException('User already has this permission');
        }
        $userPermission = $this->userPermissionRepository->registerPermission($data->permissionName, $user);
        return $this->json($userPermission);
    }
}
