<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class LoginDTO
{
    #[Assert\NotBlank(message: 'Missing camp: email')]
    public string $email;

    #[Assert\NotBlank(message: 'Missing camp: password')]
    public string $password;

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
