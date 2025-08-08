<?php

namespace App\DTO;

use App\Entity\Lists;

class SerializableLists
{
    public \DateTimeImmutable $createdAt;
    public \DateTimeImmutable $updatedAt;
    public int $id;
    public string $name;
    public ?string $description;
    public int $listId;

    /** @var SerializableListItems[] */
    public array $items;

    public function __construct(Lists $list)
    {
        $this->createdAt = $list->getCreatedAt();
        $this->updatedAt = $list->getUpdatedAt();
        $this->id = $list->getId();
        $this->name = $list->getName();
        $this->description = $list->getDescription();
        $this->items = $this->getSerializableListItems($list->getItems());
    }

    /**
     * @param \Doctrine\Common\Collections\Collection<int, \App\Entity\ListItems> $items
     * @return SerializableListItems[]
     */
    private function getSerializableListItems(\Doctrine\Common\Collections\Collection $items): array
    {
        $serializables = [];
        foreach ($items as $item) {
            $serializables[] = new SerializableListItems($item);
        }
        return $serializables;
    }
}
