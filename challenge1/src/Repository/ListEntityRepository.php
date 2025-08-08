<?php

namespace App\Repository;

use App\Entity\ListEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListEntity>
 */
class ListEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListEntity::class);
    }


    public function createList(string $name, ?string $description, bool $flush = true): ListEntity
    {
        $list = new ListEntity();

        $list->setName($name);
        $list->setDescription($description);

        $this->getEntityManager()->persist($list);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $list;
    }

    public function getListByID(int $id): ?ListEntity
    {
        return $this->find($id);
    }

    public function deleteListbyID(int $id, bool $flush = true): static
    {
        $listRef = $this->getEntityManager()->getReference(ListEntity::class, $id);
        $this->getEntityManager()->remove($listRef);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $this;
    }
}
