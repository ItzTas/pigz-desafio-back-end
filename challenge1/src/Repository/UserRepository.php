<?php

namespace App\Repository;

use App\Entity\User;
use App\Services\AuthService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, AuthService $authService)
    {
        parent::__construct($registry, User::class);
    }

    public function registerUser(string $name, string $email, string $hashedPassword, bool $flush = true): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setName($name);
        $user->setPassword($hashedPassword);
        $this->getEntityManager()->persist($user);
        return $user;
    }
}
