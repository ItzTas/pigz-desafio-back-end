<?php

namespace App\Repository;

use App\DTO\CreateListDTO;
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

    public function createList(CreateListDTO $data): Lists
    {
        $list = new Lists();

        $list->setName($data->getName());
        $list->setDescription($data->getDescription());

        $this->getEntityManager()->persist($list);
        $this->getEntityManager()->flush();

        return $list;
    }
}
