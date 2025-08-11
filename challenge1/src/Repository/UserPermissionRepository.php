<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserPermission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserPermission>
 */
class UserPermissionRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private PermissionRepository $permissionRepository,
    ) {
        parent::__construct($registry, UserPermission::class);
    }

    public function registerPermission(string $permissionName, User $user)
    {
        $permission = $this->permissionRepository->findPermissionByName($permissionName);
    }
}
