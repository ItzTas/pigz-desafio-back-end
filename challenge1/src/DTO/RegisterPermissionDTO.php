<?php

namespace App\DTO;

use App\Entity\Permission;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RegisterPermissionDTO
{
    #[Assert\NotBlank(message: 'Missing camp: permission_name')]
    public string $permissionName;

    #[Assert\Callback]
    public function validatePermissionName(ExecutionContextInterface $context): void
    {
        $availablePermissions = array_column(Permission::getPermissions(), 'name');
        if (!in_array($this->permissionName, $availablePermissions)) {
            $context->buildViolation("Permission $this->permissionName does not exist")
                ->atPath('permissionName')
                ->addViolation();
        }
    }
}
