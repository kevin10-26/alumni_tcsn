<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
class ReportsDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 50)]
    private string $type;

    #[ORM\Column(type: 'string', length: 255)]
    private string $topic;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $updatedAt;

    #[ORM\Column(type: 'string', length: 50)]
    private string $status;

    #[ORM\ManyToOne(targetEntity: UserDoctrine::class)]
    #[ORM\JoinColumn(name: 'author_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?UserDoctrine $author = null;

    #[ORM\Column(type: 'bigint')]
    private int $targetId;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $reason;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $decision;

    #[ORM\OneToMany(
        targetEntity: AttachmentsReportDoctrine::class,
        mappedBy: 'report',
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $attachments;

    public function __construct()
    {
        $this->attachments = new ArrayCollection();
    }

    // Getters/Setters standards
    public function getId(): int { return $this->id; }
    public function getType(): string { return $this->type; }
    public function setType(string $type): self { $this->type = $type; return $this; }
    public function getTopic(): string { return $this->topic; }
    public function setTopic(string $topic): self { $this->topic = $topic; return $this; }
    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }
    public function getCreatedAt(): \DateTime { return $this->createdAt; }
    public function setCreatedAt(\DateTime $createdAt): self { $this->createdAt = $createdAt; return $this; }
    public function getUpdatedAt(): \DateTime { return $this->updatedAt; }
    public function setUpdatedAt(\DateTime $updatedAt): self { $this->updatedAt = $updatedAt; return $this; }
    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }
    public function getAuthor(): ?UserDoctrine { return $this->author; }
    public function setAuthor(?UserDoctrine $author): self { $this->author = $author; return $this; }
    
    public function getTargetId(): int { return $this->targetId; }
    public function setTargetId(int $targetId): self { $this->targetId = $targetId; return $this; }

    public function getDecision(): string { return $this->decision; }
    public function setDecision(string $decision): self { $this->decision = $decision; return $this; }

    public function getReason(): string { return $this->reason; }
    public function setReason(string $reason): self { $this->reason = $reason; return $this; }

    public function getAttachments(): Collection { return $this->attachments; }

    public function addAttachment(AttachmentsReportDoctrine $attachment): self
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments->add($attachment);
            $attachment->setReport($this);
        }
        return $this;
    }

    public function removeAttachment(AttachmentsReportDoctrine $attachment): self
    {
        if ($this->attachments->removeElement($attachment)) {
            if ($attachment->getReport() === $this) {
                $attachment->setReport(null);
            }
        }
        return $this;
    }
}