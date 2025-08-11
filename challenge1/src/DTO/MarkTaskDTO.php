<?php

namespace App\DTO;

class MarkTaskDTO
{
    public ?bool $isDone;

    public function getIsDone(): bool
    {
        return $this->isDone;
    }
}
