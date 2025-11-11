<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ReactivateAccount;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;

class ReactivateAccountUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(ReactivateAccountRequest $request): ReactivateAccountResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->userId]);

        // Avoid that delegates deactivate their peers' accounts
        if ($request->userId === $user->id || ($user->hasBeenDelegate() && $request->userId === $user->id))
        {
            $reactivation = $this->userRepository->reactivateAccount($request->userId);
        }

        return new ReactivateAccountResponse(
            status: isset($reactivation) && $reactivation ? 200 : 500
        );
    }
}