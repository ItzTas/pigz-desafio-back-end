<?php

namespace App\Service;

use App\Utils\TimeUtils;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class TokenService
{
    public function __construct(
        #[Autowire(env: 'JWT_SECRET')] private string $jwtSecret,
    ) {}

    public function encode(int $userID, array $payload = []): string
    {
        if (!array_key_exists('id', $payload)) {
            $payload['id'] = $userID;
        }
        if (!array_key_exists('exp', $payload)) {
            $payload['exp'] = time() + 3600;
        }
        $payload['iat'] = TimeUtils::getTimeNowUTC();
        return JWT::encode($payload, $this->jwtSecret, 'HS256');
    }

    /**
     *
     * @return array{
     *    id: int,
     *    iat: \DateTimeImmutable,
     *    exp: \DateTimeImmutable
     *    string: mixed
     * }
     */
    public function decode(string $token): array
    {
        $decoded = JWT::decode($token, new Key($this->jwtSecret, 'HS256'));
        return (array) $decoded;
    }
}
