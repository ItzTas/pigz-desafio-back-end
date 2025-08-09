<?php

namespace App\DataFixtures;

use App\Entity\Permission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->loadPermissions($manager)
            ->loadSuperUser($manager);

        $manager->flush();
    }

    private function loadPermissions(ObjectManager $manager): static
    {
        $permissions = [[
            'name' => 'CREATE_USERS',
            'description' => 'Create and register new users',
        ]];
        foreach ($permissions as $perm) {
            $permission = new Permission();
            $permission->setName($perm['name']);
            $permission->setDescription($perm['description']);
            $manager->persist($permission);
        }
        return $this;
    }

    private function loadSuperUser(ObjectManager $manager): static
    {
        return $this;
    }
}
