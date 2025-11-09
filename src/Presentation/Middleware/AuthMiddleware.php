<?php declare(strict_types=1);

namespace Alumni\Presentation\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;

use Alumni\Domain\Service\AuthServiceInterface;
use Alumni\Application\UseCase\AuthenticateUser\AuthenticateUserResponse;

class AuthMiddleware implements MiddlewareInterface
{

    public function __construct(
        private readonly AuthServiceInterface $authService
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            // Vérifier si on a un token dans les cookies ou headers
            $authHeader = $request->getHeaderLine('Authorization');
            $token = null;

            if (!empty($authHeader) && str_starts_with($authHeader, 'Bearer ')) {
                $token = substr($authHeader, 7);
            } elseif (isset($_COOKIE['access_token'])) {
                $token = $_COOKIE['access_token'];
            }

            $token = json_decode($this->authService->generateAuthToken(1), true)['token'];

            if (empty($token)) {
                return new \Laminas\Diactoros\Response\JsonResponse(
                    ['error' => 'No token provided'],
                    401,
                    ['Content-Type' => 'application/json']
                );
            }

            // Vérifier le token
            $this->authService->verifyToken($token);

            if (!$this->authService->isUserValid()) {
                return new \Laminas\Diactoros\Response\JsonResponse(
                    ['error' => 'Invalid user'],
                    401,
                    ['Content-Type' => 'application/json']
                );
            }

            $decodedToken = $this->authService->getDecodedToken();

            // On prépare un DTO représentant l'utilisateur authentifié
            $user = new AuthenticateUserResponse(
                token: $decodedToken
            );

            // On injecte dans la requête pour le UseCase
            $request = $request->withAttribute('user', $user);

            return $handler->handle($request);

        } catch (\Exception $e) {
            return new \Laminas\Diactoros\Response\JsonResponse(
                ['error' => 'Unauthorized: ' . $e->getMessage()],
                401,
                ['Content-Type' => 'application/json']
            );
        }
    }
}