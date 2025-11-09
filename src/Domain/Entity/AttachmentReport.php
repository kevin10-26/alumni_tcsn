<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

/**
 * Represents an attachment associated with a report in the domain layer.
 * 
 * This entity contains file metadata and a reference to the parent report.
 * It is used to represent file attachments that users can add to their reports.
 */
class AttachmentReport
{
    /**
     * @param int $id Unique identifier for the attachment
     * @param string $filename The stored filename of the attachment
     * @param string $originalName The original filename as uploaded by the user
     * @param string $mimeType The MIME type of the file (e.g., 'image/jpeg', 'application/pdf')
     * @param int $fileSize The size of the file in bytes
     * @param string $filePath The path or URL where the file is stored
     * @param \DateTime $uploadedAt The date and time when the file was uploaded
     * @param Report $report The report this attachment belongs to
     */
    public function __construct(
        public int $id,
        public string $filename,
        public string $originalName,
        public string $mimeType,
        public int $fileSize,
        public string $filePath,
        public \DateTime $uploadedAt,
        public Report $report
    ) {}
}

