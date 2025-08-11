<?php

namespace App\Service;

use App\Entity\Permission;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthService
{
    public function hasUserPermission(string $permissionName, User $user): bool
    {
        if (!in_array($permissionName, Permission::getPermissions())) {
            throw new HttpException(500, "Permission with name: $permissionName does not exist");
        }

        foreach ($user->getUserPermissions() as $userPermission) {
            $permission = $userPermission->getPermission();
            if ($permission === null) {
                continue;
            }
            if ($permission->getName() === $permissionName) {
                return true;
            }
        }
        return false;
    }
}
