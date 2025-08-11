<?php

namespace App\Repository;

use App\Entity\ListItem;
use App\Entity\ListEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListItem>
 */
class ListItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListItem::class);
    }

    public function createItem(string $name, ?string $description, ListEntity $list, bool $flush = true)
    {
        $item = new ListItem()
            ->setDescription($description)
            ->setName($name)
            ->setListEntity($list);

        $this->getEntityManager()->persist($item);
        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $item;
    }

    public function markItem(ListItem $item, bool $isDone = true,  bool $flush = true): ListItem
    {
        $item->setIsDone($isDone);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $item;
    }
    public function findItemByID(int $id): ?ListItem
    {
        return $this->find($id);
    }

    public function deleteItemByID(int $id, bool $flush = true): static
    {
        $taskRef = $this->getEntityManager()->getReference(ListItem::class, $id);
        $this->getEntityManager()->remove($taskRef);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $this;
    }
}
