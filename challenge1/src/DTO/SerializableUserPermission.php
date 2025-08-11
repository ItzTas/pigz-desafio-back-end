<?php

namespace App\DTO;

use App\Entity\UserPermission;

class SerializableUserPermission
{
    public ?\DateTimeImmutable $createdAt = null;
    public ?\DateTimeImmutable $updatedAt = null;
    public ?int $id = null;
    public ?int $userEntityID = null;
    public ?int $permissionID = null;

    public function __construct(UserPermission $userPermission)
    {
        $this->createdAt = $userPermission->getCreatedAt();
        $this->updatedAt = $userPermission->getUpdatedAt();
        $this->id = $userPermission->getId();
        $this->userEntityID = $userPermission->getUserEntity()?->getId();
        $this->permissionID = $userPermission->getPermission()?->getId();
    }
}
