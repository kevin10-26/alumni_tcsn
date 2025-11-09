<?php

declare(strict_types=1);

namespace Alumni\Infrastructure\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use Alumni\Domain\Service\JWTServiceInterface;

/**
 * Service implementation for JWT token operations.
 * 
 * This service handles JWT token validation and signing using RSA256 algorithm.
 * It uses private/public key pairs for token signing and verification.
 */
class JWTService implements JWTServiceInterface
{
    /**
     * @var string Path to the private key file
     */
    private string $privateKey;

    /**
     * @var string Passphrase for the private key
     */
    private string $privKeyPassPhrase;

    /**
     * @var string Path to the public key file
     */
    private string $publicKey = '';

    /**
     * Creates a new instance of JWTService.
     * 
     * @param string $pathToPrivateKey Path to the private key file
     * @param string $privKeyPassPhrase Passphrase for decrypting the private key
     * @param string $pathToPublicKey Path to the public key file
     */
    public function __construct(
        string $pathToPrivateKey,
        string $privKeyPassPhrase,
        string $pathToPublicKey
    ) {
        $this->privateKey = $pathToPrivateKey;
        $this->privKeyPassPhrase = $privKeyPassPhrase;
        $this->publicKey = $pathToPublicKey;
    }

    /**
     * Validates a JWT token and returns its decoded claims.
     * 
     * This method decodes and validates a JWT token using the public key.
     * It also verifies that the token type is 'access'.
     * 
     * @param string $token The JWT token string to validate
     * @return array<string, mixed> The decoded token claims
     * @throws \Exception If the token is empty, invalid, or not an access token
     */
    public function validateToken(string $token): array
    {
        if (!$token) {
            throw new \Exception('Invalid token');
        }

        try {
            // Clean the token
            $token = trim($token);

            // Decode the token
            $decoded = (array) JWT::decode($token, new Key(file_get_contents($_ENV['PUBLIC_KEY_PATH']), 'RS256'));
            
            // Verify that it's an access token
            if (!isset($decoded['type']) || $decoded['type'] !== 'access') {
                throw new \Exception('Invalid token type');
            }
            
            return $decoded;
        } catch (\Exception $e) {
            throw new \Exception('Invalid token: ' . $e->getMessage());
        }
    }

    /**
     * Signs a JWT token with the provided payload.
     * 
     * This method creates a JWT token with default claims (issuer, audience, issued at, expiration)
     * merged with the provided payload, and signs it using the private key.
     * 
     * @param array<string, mixed> $payload The custom claims to include in the token
     * @return string The signed JWT token string
     */
    public function signToken(array $payload): string
    {
        $defaultPayload = [
            "iss" => "http://alumni.localhost/",
            "aud" => "http://alumni.localhost/",
            "iat" => time(),
            "exp" => time() + 3600,
        ];

        $payload = array_merge($defaultPayload, $payload);

        $keyContent = file_get_contents($_ENV['PRIVATE_KEY_PATH']);
        
        $pKey = openssl_pkey_get_private($keyContent, $_ENV['PRIVATE_KEY_PASSPHRASE']);

        $token = JWT::encode($payload, $pKey, 'RS256');

        return $token;
    }
}