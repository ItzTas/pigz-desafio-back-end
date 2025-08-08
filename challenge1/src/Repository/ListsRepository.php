<?php

namespace App\Repository;

use App\Entity\Lists;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lists>
 */
class ListsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lists::class);
    }


    public function createList(string $name, ?string $description, bool $flush = true): Lists
    {
        $list = new Lists();

        $list->setName($name);
        $list->setDescription($description);

        $this->getEntityManager()->persist($list);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $list;
    }

    public function getListByID(int $id): ?Lists
    {
        return $this->find($id);
    }

    public function deleteListbyID(int $id, bool $flush = true): static
    {
        $listRef = $this->getEntityManager()->getReference(Lists::class, $id);
        $this->getEntityManager()->remove($listRef);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $this;
    }
}
