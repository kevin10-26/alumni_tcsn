<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateUserJobProfile;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;

class UpdateUserJobProfileUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(UpdateUserJobProfileRequest $request): UpdateUserJobProfileResponse
    {
        $update = $this->userRepository->update($request->userId, $request->field, $request->value);

        return new UpdateUserJobProfileResponse(
            status: $update ? 200 : 500,
            msg: $update ? 'Vos informations ont été mises à jour' : 'Nous n\'avons pas pu mettre à jour vos informations'
        );
    }
}