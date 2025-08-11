<?php

namespace App\Repository;

use App\Entity\Permission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Permissions>
 */
class PermissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Permission::class);
    }

    public function findPermissionByName(string $permissionName): ?Permission
    {
        return $this->findOneBy(['name' => $permissionName]);
    }
}
