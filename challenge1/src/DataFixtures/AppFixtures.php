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
        private UserPasswordHasherInterface $passwordHasher,
        private UserPermissionRepository $userPermissionRepository,
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
        $permission = $manager->getRepository(Permission::class)->findOneBy(['name' => 'CREATE_USER']);

        $user = new User()
            ->setName('superuser')
            ->setEmail('superuser@email');
        $password = $this->passwordHasher->hashPassword($user, 'password');
        $user->setPassword($password);

        $manager->persist($user);

        $this->userPermissionRepository->registerPermission('CREATE_USER', $user, false);

        return $this;
    }
}
