<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\RefreshToken;
use Alumni\Infrastructure\Entity\RefreshToken as RefreshTokenDoctrine;

class RefreshTokenMapper
{
    public function toDomain(RefreshTokenDoctrine $refreshTokenDoctrine): RefreshToken
    {
        return new RefreshToken(
            token: $refreshTokenDoctrine->getToken(),
            adminId: $refreshTokenDoctrine->getAdminId(),
            expiresAt: $refreshTokenDoctrine->getExpiresAt(),
            createdAt: $refreshTokenDoctrine->getCreatedAt()
        );
    }

    public function toDoctrine(RefreshToken $refreshToken): RefreshTokenDoctrine
    {
        return new RefreshTokenDoctrine(
            $refreshToken->token,
            $refreshToken->adminId,
            $refreshToken->expiresAt
        );
    }
}
