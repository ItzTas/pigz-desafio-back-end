<?php

namespace App\Repository;

use App\Entity\ListItems;
use App\Entity\Lists;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListItems>
 */
class ListItemsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListItems::class);
    }

    public function createItem(string $name, ?string $description, Lists $list, bool $flush = true)
    {
        $item = new ListItems();

        $item->setDescription($description);
        $item->setName($name);
        $item->setList($list);

        $this->getEntityManager()->persist($item);
        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $item;
    }

    public function markItem(ListItems $item, bool $isDone = true,  bool $flush = true): ListItems
    {
        $item->setIsDone($isDone);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $item;
    }
    public function getItemByID(int $id): ?ListItems
    {
        return $this->find($id);
    }

    public function deleteItemByID(int $id, bool $flush = true): static
    {
        $taskRef = $this->getEntityManager()->getReference(ListItems::class, $id);
        $this->getEntityManager()->remove($taskRef);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $this;
    }
}
