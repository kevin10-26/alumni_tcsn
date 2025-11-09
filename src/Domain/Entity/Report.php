<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

use Alumni\Domain\Entity\User;

/**
 * Represents a report in the domain layer.
 * 
 * A report is a user-submitted issue or complaint that can be associated with
 * various entities (channels, posts, users, job offers) and can include
 * file attachments as supporting evidence.
 */
class Report
{
    /**
     * @param int $id Unique identifier for the report
     * @param string $type The type of report (e.g., 'channel', 'post', 'user', 'job_offer')
     * @param string $topic The subject or title of the report
     * @param string $description Detailed description of the issue being reported
     * @param \DateTime $createdAt The date and time when the report was created
     * @param \DateTime $updatedAt The date and time when the report was last updated
     * @param string $status The current status of the report (e.g., 'unresolved', 'resolved')
     * @param User $user The user who created the report
     * @param array<AttachmentReport> $attachments Array of file attachments associated with this report
     */
    public function __construct(
        public int $id,
        public string $type,
        public string $topic,
        public string $description,
        public \DateTime $createdAt,
        public \DateTime $updatedAt,
        public string $status,
        public User $user,
        public array $attachments = []
    ) {}
}