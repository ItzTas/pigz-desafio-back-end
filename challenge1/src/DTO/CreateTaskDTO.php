<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CreateTaskDTO
{
    #[Assert\NotBlank(message: 'Missing camp: name')]
    public string $name;

    public ?string $description = null;

    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
