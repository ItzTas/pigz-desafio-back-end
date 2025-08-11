<?php

namespace App\Repository;

use App\Entity\Permission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Permission>
 */
class PermissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Permission::class);
    }

    public function findPermissionByName(string $permissionName): ?Permission
    {
        $permissionName = strtoupper($permissionName);
        return $this->findOneBy(['name' => $permissionName]);
    }

    public function findPermissionByID(int $permissionID): ?Permission
    {
        return $this->find($permissionID);
    }

    public function createPermissions()
    {
        $permissions = Permission::getPermissions();
        foreach ($permissions as $permissionData) {
            $existingPermission = $this->permissionRepository->findOneBy([
                'name' => $permissionData['name']
            ]);

            if ($existingPermission) {
                continue;
            }

            $permission = new Permission();
            $permission->setName($permissionData['name'])
                ->setDescription($permissionData['description']);

            $this->getEntityManager()->persist($permission);
        }

        $this->getEntityManager()->flush();
    }
}
