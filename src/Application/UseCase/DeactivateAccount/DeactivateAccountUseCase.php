<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\DeactivateAccount;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;

class DeactivateAccountUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(DeactivateAccountRequest $request): DeactivateAccountResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->userId]);

        // Avoid that delegates deactivate their peers' accounts
        if ($request->userId === $user->id || ($user->hasBeenDelegate() && $request->userId === $user->id))
        {
            $deactivationEndTimestamp = time() + ($request->daysDeactivated) * 24 * 60 * 60;
            $deactivationEnd = date('d-m-Y', $deactivationEndTimestamp);

            $origin = ($user->hasBeenDelegate() && $user->id !== $request->userId) ? 'delegate' : 'self';

            $deactivation = $this->userRepository->deactivate($request->userId, $deactivationEnd, $origin);
        }

        return new DeactivateAccountResponse(
            status: isset($deactivation) && $deactivation ? 200 : 500
        );
    }
}