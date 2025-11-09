<?php

declare(strict_types=1);

namespace Alumni\Domain\Service;

interface AuthServiceInterface
{
    /**
     * Vérifie et valide un token JWT
     *
     * @param string|null $token Token JWT à vérifier
     * @return self Instance courante pour le chaînage
     * @throws \Exception Si le token est invalide
     */
    public function verifyToken(?string $token): self;

    /**
     * Récupère le token décodé
     *
     * @return array Token décodé
     */
    public function getDecodedToken(): array;

    /**
     * Vérifie si l'utilisateur associé au token est valide
     *
     * @return bool True si l'utilisateur est valide
     */
    public function isUserValid(): bool;

    /**
     * Génère un token d'authentification pour un administrateur
     *
     * @param int $adminId ID de l'administrateur
     * @return string Token d'authentification au format JSON
     */
    public function generateAuthToken(int $adminId): string;

    /**
     * Rafraîchit un token d'accès en utilisant un refresh token
     *
     * @param string $refreshToken Refresh token à utiliser
     * @return string|null Nouveau token d'accès ou null en cas d'échec
     */
    public function refreshToken(string $refreshToken): ?string;

    /**
     * Authentifie un utilisateur avec email/password
     *
     * @param string $email Email de l'utilisateur
     * @param string $password Mot de passe
     * @return string|null Token d'authentification ou null en cas d'échec
     */
    public function authenticateUser(string $email, string $password): ?string;

    /**
     * Déconnexion - supprime les cookies et refresh tokens
     *
     * @return void
     */
    public function logout(): void;
}
