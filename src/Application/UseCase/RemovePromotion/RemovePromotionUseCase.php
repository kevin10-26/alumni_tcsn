<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RemovePromotion;

use Alumni\Domain\Repository\DB\StudentRepositoryInterface;
use Alumni\Domain\Repository\DB\UserRepositoryInterface;

class RemovePromotionUseCase
{
    public function __construct(
        private readonly StudentRepositoryInterface $studentRepository,
        private readonly UserRepositoryInterface $userRepository        
    ) {}

    public function execute(RemovePromotionRequest $request): RemovePromotionResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->userId]);
        if (is_null($user) || !$user->hasBeenDelegate())
        {
            throw new \RuntimeException('Vous ne pouvez pas effectuer cette action', 400);
            exit;
        }

        $removal = $this->studentRepository->removePromotion($request->promId);

        return new RemovePromotionResponse(
            status: $removal ? 200 : 500,
            msg: $removal ? 'Le channel a bien été supprimé' : 'Le channel n\'a pas pu être supprimé'
        );
    }
}