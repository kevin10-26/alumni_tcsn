<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Doctrine entity representing a report attachment in the database.
 * 
 * This entity maps to the attachments_report table and stores file metadata
 * for attachments associated with reports. The relationship with ReportsDoctrine
 * is configured with CASCADE DELETE to ensure attachments are removed when
 * their parent report is deleted.
 */
#[ORM\Entity]
class AttachmentsReportDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $filename;

    #[ORM\Column(type: 'string', length: 100)]
    private string $mimeType;

    #[ORM\Column(type: 'bigint')]
    private int $fileSize;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $uploadedAt;

    #[ORM\ManyToOne(targetEntity: ReportsDoctrine::class, inversedBy: 'attachments')]
    #[ORM\JoinColumn(name: 'report_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?ReportsDoctrine $report_id = null;

    /**
     * Gets the unique identifier of the attachment.
     * 
     * @return int The attachment ID
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets the stored filename of the attachment.
     * 
     * @return string The filename
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Sets the stored filename of the attachment.
     * 
     * @param string $filename The filename to set
     * @return self Returns $this for method chaining
     */
    public function setFilename(string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * Gets the MIME type of the file.
     * 
     * @return string The MIME type (e.g., 'image/jpeg', 'application/pdf')
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * Sets the MIME type of the file.
     * 
     * @param string $mimeType The MIME type to set
     * @return self Returns $this for method chaining
     */
    public function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * Gets the size of the file in bytes.
     * 
     * @return int The file size in bytes
     */
    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    /**
     * Sets the size of the file in bytes.
     * 
     * @param int $fileSize The file size to set
     * @return self Returns $this for method chaining
     */
    public function setFileSize(int $fileSize): self
    {
        $this->fileSize = $fileSize;
        return $this;
    }

    /**
     * Gets the date and time when the file was uploaded.
     * 
     * @return \DateTime The upload timestamp
     */
    public function getUploadedAt(): \DateTime
    {
        return $this->uploadedAt;
    }

    /**
     * Sets the date and time when the file was uploaded.
     * 
     * @param \DateTime $uploadedAt The upload timestamp to set
     * @return self Returns $this for method chaining
     */
    public function setUploadedAt(\DateTime $uploadedAt): self
    {
        $this->uploadedAt = $uploadedAt;
        return $this;
    }

    /**
     * Gets the report this attachment belongs to.
     * 
     * @return ReportsDoctrine|null The parent report, or null if not set
     */
    public function getReportId(): ?ReportsDoctrine
    {
        return $this->report_id;
    }

    /**
     * Sets the report this attachment belongs to.
     * 
     * @param ReportsDoctrine|null $report_id The parent report to set, or null to unset
     * @return self Returns $this for method chaining
     */
    public function setReportId(?ReportsDoctrine $report_id): self
    {
        $this->report_id = $report_id;
        return $this;
    }
}

