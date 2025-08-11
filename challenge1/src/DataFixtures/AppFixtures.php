<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\PermissionRepository;
use App\Repository\UserPermissionRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private UserPermissionRepository $userPermissionRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private PermissionRepository $permissionRepository,
        private UserRepository $userRepository,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $this->loadPermissions()
            ->loadSuperUser($manager);

        $superuser = $this->userRepository->findUserByEmail('superuser@email');
        $this->userPermissionRepository->registerPermission('CREATE_USER', $superuser);
    }

    /**
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['user_permissions'];
    }

    private function loadPermissions(): static
    {
        $this->permissionRepository->createPermissions();
        return $this;
    }

    private function loadSuperUser(): static
    {
        $email = 'superuser@email';
        $name = 'superuser';
        $user_password = 'password';

        $user = new User()
            ->setName($name)
            ->setEmail($email);
        $password = $this->passwordHasher->hashPassword($user, $user_password);
        $user->setPassword($password);
        $user = $this->userRepository->registerUserClass($user);

        return $this;
    }
}
