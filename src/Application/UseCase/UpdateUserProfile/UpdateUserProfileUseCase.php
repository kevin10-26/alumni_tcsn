<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateUserProfile;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;

class UpdateUserProfileUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(UpdateUserProfileRequest $request): UpdateUserProfileResponse
    {
        $update = $this->userRepository->update($request->userId, $request->field, $request->value);

        return new UpdateUserProfileResponse(
            status: $update ? 200 : 500,
            msg: $update ? "Vos informations ont été modifiées" : "Nous n'avons pas pu modifier vos informations",
            updatedValue: $request->value
        );
    }
}