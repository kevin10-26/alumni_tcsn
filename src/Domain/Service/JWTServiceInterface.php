<?php

declare(strict_types=1);

namespace Alumni\Domain\Service;

interface JWTServiceInterface
{
    /**
     * Valide un token JWT et retourne les claims décodés
     *
     * @param string $token Token JWT à valider
     * @return array Claims du token décodé
     * @throws \Exception Si le token est invalide
     */
    public function validateToken(string $token): array;

    /**
     * Génère un token JWT signé avec les données fournies
     *
     * @param array $payload Données à inclure dans le token
     * @return string Token JWT signé
     */
    public function signToken(array $payload): string;
}
