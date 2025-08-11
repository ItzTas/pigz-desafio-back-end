<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthUtils
{
    public static function getBearerToken(Request $req): ?string
    {
        $authorizationHeader = $req->headers->get('Authorization');
        if ($authorizationHeader === null) {
            throw new UnauthorizedHttpException('Missing token');
        }
        $headerParts = explode(' ', $authorizationHeader);

        if ($headerParts[0] !== 'Bearer' || count($headerParts) !== 2) {
            throw new UnauthorizedHttpException('Bearer', 'Malformed token');
        }

        return $headerParts[1];
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
    public static function getTokenFromRequest(Request $req): array
    {
        $payload = $req->attributes->get('jwt_payload');
        return $payload;
    }
}
