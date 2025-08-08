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
        $item->setListID($list);

        $this->getEntityManager()->persist($item);
        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $item;
    }
}
