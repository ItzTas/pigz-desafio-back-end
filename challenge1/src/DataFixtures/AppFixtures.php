<?php

namespace App\DataFixtures;

use App\Entity\Permission;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadPermissions($manager)
            ->loadSuperUser($manager)
            ->loadRoles($manager);

        $manager->flush();
    }

    private function loadRoles(ObjectManager $manager): static
    {
        $roles = Role::getRoles();
        foreach ($roles as $r) {
            $role = new Role();
            $role->setName($r['name']);
            $role->setDescription($r['description']);
            $manager->persist($role);
        }
        return $this;
    }

    private function loadPermissions(ObjectManager $manager): static
    {
        $permissions = Permission::getPermissions();
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
