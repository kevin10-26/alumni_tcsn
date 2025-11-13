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
     * @param string $type The type of target being reported (e.g., 'channel', 'post', 'user', 'jobOffer', 'announce')
     * @param string $topic The subject or title of the report
     * @param string $description Detailed description of the issue being reported
     * @param \DateTime $createdAt The date and time when the report was created
     * @param \DateTime $updatedAt The date and time when the report was last updated
     * @param string $status The current status of the report (e.g., 'pending', 'under_review', 'resolved', 'rejected')
     * @param User $author The user who created/submitted the report
     * @param object|null $target The entity being reported (Channel, Post, User, JobOffer, or Announce). Can be null if the target was deleted.
     * @param array<AttachmentReport> $attachments Array of file attachments providing evidence for this report
     */
    public function __construct(
        public readonly int $id,
        public readonly string $type,
        public readonly string $topic,
        public readonly string $description,
        public readonly \DateTime $createdAt,
        public readonly \DateTime $updatedAt,
        public readonly string $status,
        public readonly ?User $author,
        public readonly ?object $target,
        public readonly array $attachments = []
    ) {}
}