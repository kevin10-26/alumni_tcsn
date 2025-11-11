<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\UsersDeactivated;
use Doctrine\Common\Collections\Collection;

class UsersDeactivatedMapper
{
    public function toDomain(Collection $doctrineDeactivations): array
    {
        $deactivations = [];
        foreach($doctrineDeactivations as $deactivation)
        {
            $deactivations[] = new UsersDeactivated(
                id: $doctrineDeactivations->getId(),
                user: $user ?? $doctrineDeactivations->getUser()->getId(),
                startedAt: $doctrineDeactivations->getStartedAt(),
                endsAt: $doctrineDeactivations->getEndsAt(),
                origin: $doctrineDeactivations->getOrigin()
            );
        }

        return $deactivations;
    }
}