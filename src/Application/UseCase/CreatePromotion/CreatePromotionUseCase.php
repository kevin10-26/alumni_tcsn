<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\CreatePromotion;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\StudentRepositoryInterface;

class CreatePromotionUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly StudentRepositoryInterface $studentRepository
    ) {}

    public function execute(CreatePromotionRequest $request): CreatePromotionResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->userId]);
        if (is_null($user) || !$user->hasBeenDelegate())
        {
            throw new \RuntimeException('Vous ne pouvez pas effectuer cette action', 400);
            exit;
        }

        $create = $this->studentRepository->createPromotion($request->name, $request->year, $request->students, $request->delegates);

        return new CreatePromotionResponse(
            status: $create ? 200 : 500,
            msg: $create ? 'La promotion a bien été créée' : 'La promotion n\'a pas pu être créée'
        );
    }
}