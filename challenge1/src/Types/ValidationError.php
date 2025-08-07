<?php

namespace App\DTO;

class ValidationError
{
    public string $propertyPath;
    public string $message;

    public function __construct(string $propertyPath, string $message)
    {
        $this->propertyPath = $propertyPath;
        $this->message = $message;
    }
}
