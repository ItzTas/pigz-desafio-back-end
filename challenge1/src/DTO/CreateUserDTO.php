<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserDTO
{
    #[Assert\NotBlank(message: 'Missing camp: email')]
    public string $email;

    #[Assert\NotBlank(message: 'Missing camp: password')]
    public string $password;

    #[Assert\NotBlank(message: 'Missing camp: name')]
    public string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPasword(string $password): static
    {
        $this->password = $password;
        return $this;
    }
}
