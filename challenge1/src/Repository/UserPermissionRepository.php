<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserPermission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

    public function registerPermission(string $permissionName, User $user, bool $flush = true): ?UserPermission
    {
        $permissionName = strtoupper($permissionName);
        if ($user === null) {
            throw new HttpException(500, 'User cannot be null');
        }

        $permission = $this->permissionRepository->findPermissionByName($permissionName);
        if ($permission === null) {
            throw new HttpException(500, "Permission: $permission does not exist");
        }

        $userPermission = new UserPermission()
            ->setUserEntity($user)
            ->setPermission($permission);
        $permission->addUserPermission($userPermission);
        $user->addUserPermission($userPermission);

        $this->getEntityManager()->persist($userPermission);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $userPermission;
    }
}
