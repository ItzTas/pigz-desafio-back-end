<?php

namespace App\DTO;

use App\Entity\ListItems;

class SerializableListItems
{
    public \DateTimeImmutable $createdAt;
    public \DateTimeImmutable $updatedAt;
    public int $id;
    public string $name;
    public ?string $description;
    public int $listId;
    public bool $isDone;

    public function __construct(ListItems $item)
    {
        $this->createdAt = $item->getCreatedAt();
        $this->updatedAt = $item->getUpdatedAt();
        $this->id = $item->getId();
        $this->name = $item->getName();
        $this->description = $item->getDescription();
        $this->isDone = $item->getIsDone();
        $this->listId = $item->getList()->getId();
    }
}
