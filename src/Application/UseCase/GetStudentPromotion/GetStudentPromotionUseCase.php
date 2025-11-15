<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetStudentPromotion;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;

class GetStudentPromotionUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(GetStudentPromotionRequest $request): GetStudentPromotionResponse
    {
        $username = $this->userRepository->getBy(['name' => $request->input]);

        return new GetStudentPromotionResponse(
            status: $username ? 200 : 500,
        );
    }
}