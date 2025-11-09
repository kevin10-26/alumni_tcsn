<?php

declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Alumni\Domain\Service\AuthServiceInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;

class AuthController
{
    public function __construct(
        private AuthServiceInterface $authService
    ) {}

    /**
     * Connexion utilisateur
     */
    public function login(ServerRequest $request): JsonResponse
    {
        $body = json_decode($request->getBody()->getContents(), true);
        
        if (!isset($body['email']) || !isset($body['password'])) {
            return new JsonResponse(
                ['error' => 'Email and password are required'],
                400
            );
        }

        $tokenResponse = $this->authService->authenticateUser(
            $body['email'], 
            $body['password']
        );

        if (!$tokenResponse) {
            return new JsonResponse(
                ['error' => 'Invalid credentials'],
                401
            );
        }

        return new JsonResponse(
            json_decode($tokenResponse, true),
            200
        );
    }

    /**
     * Rafraîchir le token d'accès
     */
    public function refreshToken(): JsonResponse
    {
        if (!isset($_COOKIE['refresh_token'])) {
            return new JsonResponse(
                ['error' => 'Refresh token is required'],
                400
            );
        }

        $newTokenResponse = $this->authService->refreshToken($_COOKIE['refresh_token']);

        if (!$newTokenResponse) {
            return new JsonResponse(
                ['error' => 'Invalid or expired refresh token'],
                401
            );
        }

        return new JsonResponse(
            json_decode($newTokenResponse, true),
            200
        );
    }

    /**
     * Déconnexion utilisateur
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return new JsonResponse(
            ['message' => 'Logged out successfully'],
            200
        );
    }

    /**
     * Vérifier le statut d'authentification
     */
    public function status(): JsonResponse
    {
        try {
            if (isset($_COOKIE['access_token'])) {
                $this->authService->verifyToken($_COOKIE['access_token']);
                
                if ($this->authService->isUserValid()) {
                    return new JsonResponse([
                        'authenticated' => true,
                        'user' => $this->authService->getDecodedToken()
                    ]);
                }
            }

            return new JsonResponse([
                'authenticated' => false
            ]);

        } catch (\Exception $e) {
            return new JsonResponse([
                'authenticated' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
