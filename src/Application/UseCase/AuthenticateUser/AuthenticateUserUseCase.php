<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\AuthenticateUser;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;

use Alumni\Domain\Service\AuthServiceInterface;

class AuthenticateUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly AuthServiceInterface $authService
    ) {}

    public function execute(AuthenticateUserRequest $request): AuthenticateUserResponse
    {
        $login = $this->userRepository->authenticate($request->emailAddress, $request->password);

        if ($login)
        {
            $token = $this->authService->getDecodedToken($this->authService->generateAuthToken($login->id));
        }

        return new AuthenticateUserResponse(
            token: $token
        );
    }
}