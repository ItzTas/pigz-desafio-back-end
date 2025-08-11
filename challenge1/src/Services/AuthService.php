<?php

namespace App\Services;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    // private UserPasswordHasherInterface $passwordHasher;
    //
    // private JWTTokenManagerInterface $jwtManager;
    //
    // private TokenExtractorInterface $tokenExtractor;

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private JWTTokenManagerInterface $jwtManager,
        private TokenExtractorInterface $tokenExtractor,
    ) {}

    public function hashPassword(User $user, string $plainPassword): string
    {
        return $this->passwordHasher->hashPassword($user, $plainPassword);
    }

    public function verifyPassword(string $plainPassword, string $hashedPassword): bool
    {
        return $this->passwordHasher->isPasswordValid;
    }

    public function getTokenInfos(Request $req): ?array
    {
        $token = $this->tokenExtractor->extract($req);
        if ($token === null) {
            return null;
        }

        return $this->jwtManager->decode($token);
    }
}
