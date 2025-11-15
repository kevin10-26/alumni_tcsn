<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\SearchStudentPromotion;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;

class SearchStudentPromotionUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(SearchStudentPromotionRequest $request): SearchStudentPromotionResponse
    {
        $usernames = $this->userRepository->searchByUsername($request->input);

        return new SearchStudentPromotionResponse(
            status: $usernames ? 200 : 500,
            usernames: $usernames
        );
    }
}