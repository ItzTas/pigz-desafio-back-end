<?php

namespace App\DTO;

use App\Entity\User;

class SerializableUser
{
    public \DateTimeImmutable $createdAt;
    public \DateTimeImmutable $updatedAt;
    public int $id;
    public string $name;
    public string $email;

    public function __construct(User $user)
    {
        $this->createdAt = $user->getCreatedAt();
        $this->updatedAt = $user->getUpdatedAt();
        $this->id = $user->getId();
        $this->name = $user->getName();
        $this->email = $user->getEmail();
    }
}
