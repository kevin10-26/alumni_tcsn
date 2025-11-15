<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\EditPromotion;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\StudentRepositoryInterface;

use Alumni\Domain\Entity\MasterProm;

class EditPromotionUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly StudentRepositoryInterface $studentRepository
    ) {}

    public function execute(EditPromotionRequest $request): EditPromotionResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->userId]);
        if (is_null($user) || !$user->hasBeenDelegate())
        {
            throw new \RuntimeException('Vous ne pouvez pas effectuer cette action', 400);
            exit;
        }

        $edit = $this->studentRepository->editPromotion($request->name, $request->promId, $request->year, $request->students, $request->delegates);
        $promotion = $this->studentRepository->getPromotionBy(['id' => $request->promId]);

        $reassignement = $this->reassignStudents($promotion, $request->students);
        $reassignement = $this->reassignDelegates($promotion, $request->delegates);

        return new EditPromotionResponse(
            status: $edit ? 200 : 500,
            msg: $edit ? 'La promotion a bien été mise à jour' : 'La promotion n\'a pas pu être mise à jour'
        );
    }

    public function reassignStudents(MasterProm $promotion, array $students): bool
    {
        $studentsToAdd = array_diff($students, array_column($promotion->students, 'userName'));
        $studentsToRemove = array_diff(array_column($promotion->students, 'userName'), $students);

        foreach ($studentsToAdd as $newStudent)
        {
            $this->studentRepository->assignPromotionToStudent($promotion->id, $newStudent, false);
        }

        foreach ($studentsToRemove as $formerStudent)
        {
            $student = $this->userRepository->getBy(['name' => $formerStudent]);
            $this->studentRepository->removeStudentFromPromotion($promotion->id, $student->id, false);
        }

        return true;
    }

    public function reassignDelegates(MasterProm $promotion, array $delegates): bool
    {
        $delegatesToAdd = array_diff($delegates, array_column($promotion->delegates, 'userName'));
        $delegatesToRemove = array_diff(array_column($promotion->delegates, 'userName'), $delegates);

        foreach ($delegatesToAdd as $newDelegate)
        {
            $delegate = $this->userRepository->getBy(['name' => $newDelegate]);
            if (is_null($delegate)) continue;

            $this->studentRepository->setStudentData($promotion->id, $delegate->id, [
                'field' => 'isDelegate',
                'value' => true
            ]);
        }

        foreach ($delegatesToRemove as $formerDelegate)
        {
            $delegate = $this->userRepository->getBy(['name' => $formerDelegate]);
            if (is_null($delegate)) continue;

            $this->studentRepository->setStudentData($promotion->id, $delegate->id, [
                'field' => 'isDelegate',
                'value' => false
            ]);
        }

        return true;
    }
}