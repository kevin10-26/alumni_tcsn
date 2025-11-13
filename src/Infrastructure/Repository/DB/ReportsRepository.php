<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;

use Psr\Http\Message\UploadedFileInterface;

use Alumni\Infrastructure\Repository\DB\Mapper\ReportsMapper;
use Alumni\Infrastructure\Repository\DB\Mapper\UserMapper;
use Alumni\Infrastructure\Repository\DB\Mapper\AttachmentsReportMapper;

use Alumni\Infrastructure\Entity\ReportsDoctrine;
use Alumni\Infrastructure\Entity\UserDoctrine;
use Alumni\Infrastructure\Entity\ChannelDoctrine;
use Alumni\Infrastructure\Entity\ChannelPostDoctrine;
use Alumni\Infrastructure\Entity\JobOfferDoctrine;
use Alumni\Infrastructure\Entity\AttachmentsReportDoctrine;

use Alumni\Domain\Repository\DB\ReportsRepositoryInterface;

use Alumni\Domain\Entity\Report;
use Alumni\Domain\Entity\User;
use Alumni\Domain\Entity\Channel;
use Alumni\Domain\Entity\ChannelPost;
use Alumni\Domain\Entity\JobOffer;

/**
 * Repository implementation for managing Report entities in the database.
 * 
 * This repository handles all database operations for reports, including
 * creation, retrieval, resolution, and deletion. It also manages the creation
 * of report attachments from file data.
 */
class ReportsRepository implements ReportsRepositoryInterface
{
    /**
     * Creates a new instance of ReportsRepository.
     * 
     * @param EntityManagerInterface $em Doctrine entity manager for database operations
     * @param ReportsMapper $reportsMapper Mapper for converting between domain and Doctrine entities
     * @param UserMapper $userMapper Mapper for converting User entities
     * @param AttachmentsReportMapper $attachmentsReportMapper Mapper for converting AttachmentReport entities
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ReportsMapper $reportsMapper,
        private readonly UserMapper $userMapper,
        private readonly AttachmentsReportMapper $attachmentsReportMapper
    ) {}

    /**
     * Retrieves all reports from the database.
     * 
     * @return array<Report> Array of all reports as domain entities
     */
    public function getAll(): array
    {
        $reportsDoctrine = $this->em->getRepository(ReportsDoctrine::class)->findAll();
        $reports = [];

        foreach($reportsDoctrine as $report)
        {
            $reports[] = $this->reportsMapper->toDomain($report);
        }

        return $reports;
    }

    public function getMultipleBy(array $condition): array
    {
        $reportsDoctrine = $this->em->getRepository(ReportsDoctrine::class)->findBy($condition);
        $reports = [];

        foreach($reportsDoctrine as $report)
        {
            $reports[] = $this->reportsMapper->toDomain($report);
        }

        return $reports;
    }

    /**
     * Retrieves a single report by the given conditions.
     * 
     * @param array<string, mixed> $condition Associative array of field => value pairs to search for
     * @return Report The found report as a domain entity
     * @throws \RuntimeException If no report is found matching the conditions
     */
    public function getBy(array $condition): Report
    {
        $report = $this->em->getRepository(ReportsDoctrine::class)->findOneBy($condition);
        
        if ($report === null) {
            throw new \RuntimeException('Report not found');
        }

        return $this->reportsMapper->toDomain($report);
    }

    /**
     * Creates a new report in the database.
     * 
     * This method creates a new report with the provided information and optionally
     * processes file attachments. The attachments array should contain 'files' and/or
     * 'pictures' keys, each containing arrays of file data with 'url', 'mimeType',
     * 'size', and optionally 'poolLocation' keys.
     * 
     * @param int $userId The ID of the user creating the report
     * @param int $entityId The ID of the entity being reported (currently unused, reserved for future use)
     * @param string $reportType The type of report (e.g., 'channel', 'channelPost', 'user', 'jobOffer')
     * @param string $reportType The domain entity of report (e.g., 'Channel', 'ChannelPost', 'User', 'JobOffer')
     * @param string $reportTopic The subject or title of the report
     * @param string $reportDescription Detailed description of the issue being reported
     * @param mixed<object|array> $attachments Array containing 'files' and/or 'pictures' with file data
     * @return void
     * @throws \RuntimeException If the user with the given ID is not found
     */
    public function create(
        int $userId,
        int $entityId,
        string $reportType,
        object $entity,
        string $reportTopic,
        string $reportDescription,
        ?array $attachments
    ): bool
    {
        $userDoctrine = $this->em->find(UserDoctrine::class, $userId);
        if ($userDoctrine === null) {
            throw new \RuntimeException('User not found');
        }

        $report = new ReportsDoctrine();
        $report->setType($reportType);
        $report->setTopic($reportTopic);
        $report->setDescription($reportDescription);
        $report->setAuthor($userDoctrine);
        $report->setStatus('unresolved');
        $report->setCreatedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $report->setUpdatedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $this->pushReportEntity($report, $entity);

        // Handle attachments if provided
        if (count($attachments) > 0) {

            foreach ($attachments as $fileData) {
                $attachment = $this->createAttachmentFromFileData($fileData, $report);
                $report->addAttachment($attachment);
            }
        }

        $this->em->persist($report);
        $this->em->flush();

        return true;
    }

    /**
     * Marks a report as resolved.
     * 
     * This method updates the report's status to 'resolved' and sets the
     * updatedAt timestamp to the current time.
     * 
     * @param Report $report The report to resolve
     * @return void
     * @throws \RuntimeException If the report is not found in the database
     */
    public function resolve(int $reportId, string $decision, string $reason): bool
    {
        $reportDoctrine = $this->em->getRepository(ReportsDoctrine::class)->find($reportId);
        if ($reportDoctrine === null) {
            throw new \RuntimeException('Report not found');
        }
        
        $reportDoctrine->setStatus('resolved');
        $reportDoctrine->setDecision($decision);
        $reportDoctrine->setReason($reason);
        $reportDoctrine->setUpdatedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $this->em->persist($reportDoctrine);
        $this->em->flush();

        return true;
    }

    /**
     * Creates an AttachmentsReportDoctrine entity from file data.
     * 
     * This private helper method extracts file information from the provided
     * file data array and creates a properly configured attachment entity.
     * It handles filename extraction from URLs and falls back to default
     * values when certain data is missing.
     * 
     * @param array<string, mixed> $fileData Array containing file information:
     *   - 'url' (string): The URL or path to the file
     *   - 'poolLocation' (string, optional): Alternative location for original filename
     *   - 'mimeType' (string, optional): MIME type (defaults to 'application/octet-stream')
     *   - 'size' (int, optional): File size in bytes (defaults to 0)
     * @param ReportsDoctrine $report The report this attachment belongs to
     * @return AttachmentsReportDoctrine The created attachment entity
     */
    private function createAttachmentFromFileData(UploadedFileInterface $fileData, ReportsDoctrine $report): AttachmentsReportDoctrine
    {
        $attachment = new AttachmentsReportDoctrine();
        
        // Set attachment properties
        $attachment->setFilename($fileData->getClientFilename());
        $attachment->setMimeType($fileData->getClientMediaType() ?? 'application/octet-stream');
        $attachment->setFileSize($fileData->getSize() ?? 0);
        $attachment->setUploadedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $attachment->setReport($report);
        
        return $attachment;
    }

    private function pushReportEntity(
        ReportsDoctrine &$report,
        object $entity
    ): void
    {
        switch ($entity)
        {
            case $entity instanceof Channel:
                $report->setTargetId($entity->id);
                break;
            
            case $entity instanceof ChannelPost:
                $report->setTargetId($entity->id);
                break;

            case $entity instanceof User:
                $report->setTargetId($entity->id);
                break;

            case $entity instanceof JobOffer:
                $report->setTargetId($entity->id);
                break;

            case $entity instanceof Announce:
                $report->setTargetId($entity->id);
                break;
        }
    }
}