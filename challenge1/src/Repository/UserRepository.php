<?php

namespace App\Repository;

use App\Entity\User;
use App\Utils\AuthUtils;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function registerUser(User $user, bool $flush = true): User
    {
        $this->getEntityManager()->persist($user);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $user;
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findUserByRequestWithToken(Request $req): ?User
    {
        $token = AuthUtils::getTokenFromRequest($req);
        $userID = $token['id'];

        return $this->find($userID);
    }
}
