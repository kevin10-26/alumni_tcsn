<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ManagePromotionModal;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\StudentRepositoryInterface;

use Alumni\Domain\Entity\MasterProm;

class ManagePromotionModalUseCase
{
    public function __construct(
        private readonly StudentRepositoryInterface $studentRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(ManagePromotionModalRequest $request): ManagePromotionModalResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->userId]);
        if (is_null($user) || !$user->hasBeenDelegate())
        {
            throw new \RuntimeException('Vous ne pouvez pas effectuer cette action', 400);
            exit;
        }

        if ($request->promId > 0)
        {
            $promotion = $this->studentRepository->getPromotionBy(['id' => $request->promId]);
            $attachedDelegates = $this->studentRepository->getPromotionDelegates($request->promId);

            return new ManagePromotionModalResponse(
                status: $promotion && $attachedDelegates ? 200 : 500,
                promotion: $promotion,
                attachedDelegates: $attachedDelegates
            );
        } else {

            return new ManagePromotionModalResponse(
                status: 200,
                promotion: new MasterProm(0, intval(date('Y')), '', [], []),
                attachedDelegates: []
            );
        }
    }
}