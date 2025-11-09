<?php

declare(strict_types=1);

namespace Alumni\Infrastructure\Service;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\RefreshTokenRepositoryInterface;
use Alumni\Domain\Service\AuthServiceInterface;

use Alumni\Infrastructure\Service\JWTServiceInterface;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Service implementation for handling authentication and authorization.
 * 
 * This service manages JWT token validation, user authentication, token generation,
 * refresh token handling, and cookie management for authentication.
 */
class AuthService implements AuthServiceInterface
{
    /**
     * @var array<string, mixed> The decoded JWT token data
     */
    private array $decodedToken = [];

    /**
     * Creates a new instance of AuthService.
     * 
     * @param EntityManagerInterface $entityManager Doctrine entity manager for database operations
     * @param UserRepositoryInterface $userRepository Repository for user operations
     * @param RefreshTokenRepositoryInterface $refreshToken Repository for refresh token operations
     * @param JWTService $jwtService Service for JWT token operations
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepositoryInterface $userRepository,
        private RefreshTokenRepositoryInterface $refreshToken,
        private JWTService $jwtService
    ) {}

    /**
     * Verifies and validates a JWT token.
     * 
     * If no token is provided, it attempts to retrieve it from the 'access_token' cookie.
     * The token is validated using JWTService and stored internally for later use.
     * 
     * @param string|null $token The JWT token to verify, or null to use cookie
     * @return self Returns $this for method chaining
     * @throws \Exception If no token is provided or if the token is invalid
     */
    public function verifyToken(?string $token): self
    {
        // Check access_token cookie first if no token provided
        if (empty($token) && isset($_COOKIE['access_token'])) {
            $token = $_COOKIE['access_token'];
        }

        if (empty($token)) {
            throw new \Exception('No token provided');
        }

        $jwt = trim(str_replace('Bearer ', '', $token));

        try {
            $decodedToken = $this->jwtService->validateToken($jwt);
            $this->decodedToken = $decodedToken;

            return $this;
        } catch (\Exception $e) {
            throw new \Exception('Invalid token: ' . $e->getMessage());
        }
    }

    /**
     * Gets the decoded token data from the last verification.
     * 
     * @return array<string, mixed> The decoded token claims
     */
    public function getDecodedToken(): array
    {
        return $this->decodedToken;
    }

    /**
     * Checks if the user from the decoded token exists and is valid.
     * 
     * @return bool Returns true if the user exists, false otherwise
     */
    public function isUserValid(): bool
    {
        if (empty($this->decodedToken) || !isset($this->decodedToken['userId'])) {
            return false;
        }

        $admin = $this->userRepository->getBy(['id' => $this->decodedToken['userId']]);
        return $admin !== null;
    }

    /**
     * Generates authentication tokens for a user.
     * 
     * This method creates both an access token (JWT) and a refresh token,
     * stores the refresh token in the database, and sets authentication cookies.
     * Old refresh tokens for the user are deleted before creating a new one.
     * 
     * @param int $userId The ID of the user
     * @return string JSON-encoded response containing token information
     * @throws \Exception If the user is not found
     */
    public function generateAuthToken(int $userId): string
    {
        // Verify that the user exists
        $admin = $this->userRepository->getBy(['id' => $userId]);
        if (!$admin) {
            throw new \Exception('Admin not found');
        }

        // Generate the access token
        $accessToken = $this->jwtService->signToken([
            'userId' => $userId,
            'type' => 'access',
            'role' => 'user' // Default role for now
        ]);

        // Generate the refresh token
        $refreshToken = bin2hex(random_bytes(32));
        $expiresAt = new \DateTime('+30 days');

        // Delete old refresh tokens for this user
        $this->refreshToken->deleteByUserId($userId);
        
        // Create the new refresh token
        $this->refreshToken->create($refreshToken, $userId, $expiresAt);

        // Set the cookies
        $this->setAuthCookies($accessToken, $refreshToken);

        return json_encode([
            'token' => $accessToken,
            'expires_in' => 3600,
            'token_type' => 'Bearer'
        ]);
    }

    /**
     * Refreshes an access token using a refresh token.
     * 
     * This method validates the refresh token, removes it, and generates
     * a new access token and refresh token pair.
     * 
     * @param string $refreshToken The refresh token string
     * @return string|null JSON-encoded response with new token information, or null if refresh token is invalid/expired
     */
    public function refreshToken(string $refreshToken): ?string
    {
        // Verify the refresh token
        $tokenEntity = $this->refreshToken->findByToken($refreshToken);
        if (!$tokenEntity || $tokenEntity->getExpiresAt() < new \DateTime()) {
            return null;
        }

        // Remove the old refresh token
        $this->refreshToken->remove($refreshToken);

        // Generate a new access token
        return $this->generateAuthToken($tokenEntity->getUserId());
    }

    /**
     * Authenticates a user with email and password.
     * 
     * Note: This method is not yet fully implemented and will throw an exception.
     * 
     * @param string $email The user's email address
     * @param string $password The user's password
     * @return string|null JSON-encoded response with token information, or null on failure
     * @throws \Exception Always throws an exception indicating the method needs implementation
     */
    public function authenticateUser(string $email, string $password): ?string
    {
        // Note: This method needs to be implemented in UserRepository
        // For now, we'll throw an exception to indicate it needs implementation
        throw new \Exception('User authentication by email not yet implemented');

        return $this->generateAuthToken($admin->getId());
    }

    /**
     * Logs out the current user.
     * 
     * This method removes the refresh token from the database and clears
     * all authentication cookies.
     * 
     * @return void
     */
    public function logout(): void
    {
        // Remove the refresh token from the database
        if (isset($_COOKIE['refresh_token'])) {
            $this->refreshToken->remove($_COOKIE['refresh_token']);
        }

        // Clear the cookies
        $this->clearAuthCookies();
    }

    /**
     * Sets authentication cookies for the user.
     * 
     * This private method sets three cookies:
     * - access_token: HttpOnly cookie containing the JWT access token (1 hour expiration)
     * - refresh_token: HttpOnly cookie containing the refresh token (30 days expiration)
     * - token_expires_at: Non-HttpOnly cookie containing the expiration timestamp (accessible to JavaScript)
     * 
     * @param string $accessToken The JWT access token
     * @param string $refreshToken The refresh token
     * @return void
     */
    private function setAuthCookies(string $accessToken, string $refreshToken): void
    {
        $cookieOptions = [
            'path' => '/',
            'domain' => $_ENV['COOKIE_DOMAIN'] ?? 'alumni.localhost',
            'secure' => $_ENV['COOKIE_SECURE'] ?? false,
            'samesite' => 'Strict'
        ];

        // Cookie for access token (1 hour) - HttpOnly for security
        setcookie('access_token', $accessToken, array_merge($cookieOptions, [
            'expires' => time() + 3600,
            'httponly' => true
        ]));

        // Cookie for refresh token (30 days) - HttpOnly for security
        setcookie('refresh_token', $refreshToken, array_merge($cookieOptions, [
            'expires' => time() + (30 * 24 * 3600),
            'httponly' => true
        ]));

        // Cookie for access token expiration date - accessible to JavaScript
        setcookie('token_expires_at', (string)(time() + 3600), array_merge($cookieOptions, [
            'expires' => time() + 3600,
            'httponly' => false
        ]));
    }

    /**
     * Clears all authentication cookies.
     * 
     * This private method removes all authentication-related cookies by
     * setting them with an expiration date in the past.
     * 
     * @return void
     */
    private function clearAuthCookies(): void
    {
        $cookieOptions = [
            'path' => '/',
            'domain' => $_ENV['COOKIE_DOMAIN'] ?? 'alumni.localhost',
            'secure' => $_ENV['COOKIE_SECURE'] ?? false,
            'samesite' => 'Strict',
            'expires' => time() - 3600 // Expire in the past
        ];

        setcookie('access_token', '', $cookieOptions);
        setcookie('refresh_token', '', $cookieOptions);
        setcookie('token_expires_at', '', $cookieOptions);
    }
}
