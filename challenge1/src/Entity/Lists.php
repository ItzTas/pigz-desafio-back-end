<?php

namespace App\Entity;

use App\Repository\ListsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListsRepository::class)]
class Lists
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, ListItems>
     */
    #[ORM\OneToMany(targetEntity: ListItems::class, mappedBy: 'listID', orphanRemoval: true)]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ListItems>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ListItems $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setListID($this);
        }

        return $this;
    }

    // public function removeItem(ListItems $item): static
    // {
    //     if ($this->items->removeElement($item)) {
    //         // set the owning side to null (unless already changed)
    //         if ($item->getListID() === $this) {
    //             $item->setListID(null);
    //         }
    //     }
    //
    //     return $this;
    // }
}
