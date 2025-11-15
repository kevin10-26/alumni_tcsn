<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RefreshPromotions;

use Alumni\Domain\Repository\DB\StudentRepositoryInterface;
use Alumni\Domain\Repository\DB\UserRepositoryInterface;

class RefreshPromotionsUseCase
{
    public function __construct(
        private readonly StudentRepositoryInterface $studentRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(RefreshPromotionsRequest $request): RefreshPromotionsResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->userId]);
        if (is_null($user) || !$user->hasBeenDelegate())
        {
            throw new \RuntimeException('Vous ne pouvez pas effectuer cette action', 400);
            exit;
        }

        $promotions = $this->studentRepository->getAllPromotions();

        foreach($promotions as $promotion)
        {
            $attachedDelegates->delegates[] = $this->studentRepository->getPromotionDelegates($promotion->id);
        }

        return new RefreshPromotionsResponse(
            status: $promotion && $attachedDelegates ? 200 : 500,
            promotions: $promotions
        );
    }
}