<?php

namespace App\DataFixtures;

use App\Entity\Permission;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $this->loadPermissions($manager);
        $this->loadSuperUser($manager);
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
            $manager->flush();
        }
        return $this;
    }

    private function loadSuperUser(ObjectManager $manager): User
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

        return $user;
    }
}
