<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateRegistrationPool;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\RegistrationPoolRepositoryInterface;

class UpdateRegistrationPoolUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly RegistrationPoolRepositoryInterface $registrationPoolRepository
    ) {}

    public function execute(UpdateRegistrationPoolRequest $request): UpdateRegistrationPoolResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->loggedUserId]);
        if (is_null($user) || !$user->hasBeenDelegate())
        {
            throw new \RuntimeException('Vous ne pouvez pas effectuer cette action', 400);
            exit;
        }

        switch ($request->decision)
        {
            case 'approve':
                $move = $this->registrationPoolRepository->moveUser($request->poolId, $request->promId);
                break;
            
            case 'refuse':
                $move = $this->registrationPoolRepository->deleteUser($request->poolId);
                break;

            default:
                $move = false;
                break;
        }

        return new UpdateRegistrationPoolResponse(
            status: $move ? 200 : 500,
            msg: $move ? 'La demande a bien été exécutée' : 'La demande n\'a pas été exécutée'
        );
    }
}