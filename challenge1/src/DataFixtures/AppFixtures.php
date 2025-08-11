<?php

namespace App\DataFixtures;

use App\Entity\Permission;
use App\Entity\User;
use App\Repository\UserPermissionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPermissionRepository $userPermissionRepository,
        private UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $this->loadPermissions($manager)
            ->loadSuperUser($manager);

        $manager->flush();
    }

    private function loadPermissions(ObjectManager $manager): static
    {
        $permissions = Permission::getPermissions();
        foreach ($permissions as $perm) {
            $permission = new Permission()
                ->setName($perm['name'])
                ->setDescription($perm['description']);
            $manager->persist($permission);
        }
        return $this;
    }

    private function loadSuperUser(ObjectManager $manager): static
    {
        $email = 'superuser@email';
        $name = 'superuser';
        $user_password = 'password';

        $user = new User()
            ->setName($name)
            ->setEmail($email);
        $password = $this->passwordHasher->hashPassword($user, $user_password);
        $user->setPassword($password);

        $manager->persist($user);

        $this->userPermissionRepository->registerPermission('CREATE_USER', $user, false);

        return $this;
    }
}
