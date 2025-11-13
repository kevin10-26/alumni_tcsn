<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Doctrine\ORM\EntityManagerInterface;

use Alumni\Domain\Entity\Report;
use Alumni\Infrastructure\Entity\ReportsDoctrine;

use Alumni\Infrastructure\Entity\UserDoctrine;
use Alumni\Infrastructure\Entity\ChannelDoctrine;
use Alumni\Infrastructure\Entity\ChannelPostDoctrine;
use Alumni\Infrastructure\Entity\AnnounceDoctrine;
use Alumni\Infrastructure\Entity\JobOfferDoctrine;

class ReportsMapper
{
    private array $mappers = [];

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserMapper $userMapper,
        private readonly AttachmentsReportMapper $attachmentsReportMapper,
        ChannelPostMapper $channelPostMapper,
        ChannelMapper $channelMapper,
        AnnounceMapper $announceMapper,
        JobOfferMapper $jobOfferMapper
    ) {
        $this->mappers = [
            'post' => $channelPostMapper,
            'channel' => $channelMapper,
            'announce' => $announceMapper,
            'jobOffer' => $jobOfferMapper,
            'user' => $userMapper,
        ];
    }

    public function toDomain(ReportsDoctrine $reportsDoctrine): Report
    {
        // Résolution de la cible
        $target = $this->resolveTarget($reportsDoctrine);

        // Création du Report sans attachments (pour éviter la dépendance circulaire)
        $report = new Report(
            id: $reportsDoctrine->getId(),
            type: $reportsDoctrine->getType(),
            topic: $reportsDoctrine->getTopic(),
            description: $reportsDoctrine->getDescription(),
            createdAt: $reportsDoctrine->getCreatedAt(),
            updatedAt: $reportsDoctrine->getUpdatedAt(),
            status: $reportsDoctrine->getStatus(),
            author: $this->userMapper->toDomain($reportsDoctrine->getAuthor()),
            target: $target,
            attachments: []
        );

        // ✅ Mapping des attachments en passant le $report
        $attachments = [];
        foreach ($reportsDoctrine->getAttachments() as $attachmentDoctrine) {
            $attachments[] = $this->attachmentsReportMapper->toDomain($attachmentDoctrine, $report);
        }
        
        // Reconstruction du Report avec les attachments
        return new Report(
            id: $report->id,
            type: $report->type,
            topic: $report->topic,
            description: $report->description,
            createdAt: $report->createdAt,
            updatedAt: $report->updatedAt,
            status: $report->status,
            author: $report->author,
            target: $report->target,
            attachments: $attachments
        );
    }

    public function toDoctrine(Report $report): ReportsDoctrine
    {
        $reportsDoctrine = new ReportsDoctrine();
        $reportsDoctrine->setType($report->type);
        $reportsDoctrine->setTopic($report->topic);
        $reportsDoctrine->setDescription($report->description);
        $reportsDoctrine->setCreatedAt($report->createdAt);
        $reportsDoctrine->setUpdatedAt($report->updatedAt);
        $reportsDoctrine->setStatus($report->status);
        $reportsDoctrine->setAuthor($this->userMapper->toDoctrine($report->author));
        $reportsDoctrine->setTargetId($this->extractTargetId($report->target));

        // Mapping des attachments
        foreach ($report->attachments as $attachment) {
            $reportsDoctrine->addAttachment(
                $this->attachmentsReportMapper->toDoctrine($attachment, $reportsDoctrine)
            );
        }

        return $reportsDoctrine;
    }

    private function resolveTarget(ReportsDoctrine $reportsDoctrine): ?object
    {
        $targetType = $reportsDoctrine->getType();
        $targetId = $reportsDoctrine->getTargetId();

        if (!isset($this->mappers[$targetType])) {
            throw new \InvalidArgumentException("Unknown target type: $targetType");
        }

        $mapper = $this->mappers[$targetType];
        $targetDoctrine = $this->loadTargetEntity($targetType, $targetId);

        if ($targetDoctrine === null) {
            return null;
        }

        return $mapper->toDomain($targetDoctrine);
    }

    private function loadTargetEntity(string $targetType, int $targetId): ?object
    {
        $entityClassMap = [
            'post' => \Alumni\Infrastructure\Entity\ChannelPostDoctrine::class,
            'channel' => \Alumni\Infrastructure\Entity\ChannelDoctrine::class,
            'announce' => \Alumni\Infrastructure\Entity\AnnounceDoctrine::class,
            'jobOffer' => \Alumni\Infrastructure\Entity\JobOfferDoctrine::class,
            'user' => \Alumni\Infrastructure\Entity\UserDoctrine::class,
        ];

        if (!isset($entityClassMap[$targetType])) {
            return null;
        }

        return $this->entityManager->getRepository($entityClassMap[$targetType])->find($targetId);
    }

    private function extractTargetId(object $target): int
    {
        if (method_exists($target, 'getId')) {
            return $target->getId();
        }

        if (property_exists($target, 'id')) {
            return $target->id;
        }

        throw new \InvalidArgumentException('Target entity must have an ID');
    }
}