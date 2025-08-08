<?php

namespace App\DTO;

class MarkTaskDTO
{
    public bool $isDone = true;

    public function getIsDone(): bool
    {
        return $this->isDone;
    }
}
