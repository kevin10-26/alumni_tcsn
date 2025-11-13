<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Alumni\Infrastructure\Entity\UserDoctrine;
use Alumni\Infrastructure\Entity\ChannelDoctrine;
use Alumni\Infrastructure\Entity\SurveyDoctrine;
use Alumni\Infrastructure\Entity\AttachmentDoctrine;
use Alumni\Infrastructure\Entity\ReportsDoctrine;

#[ORM\Entity]
class ChannelPostDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\ManyToOne(targetEntity: UserDoctrine::class)]
    #[ORM\JoinColumn(name: 'channel_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?UserDoctrine $author = null;

    #[ORM\ManyToOne(targetEntity: ChannelDoctrine::class, inversedBy: 'posts')]
    #[ORM\JoinColumn(name: 'channel_id', referencedColumnName: 'id')]
    private ChannelDoctrine $channel;

    #[ORM\OneToOne(targetEntity: SurveyDoctrine::class)]
    #[ORM\JoinColumn(name: 'survey_id', referencedColumnName: 'id')]
    private ?SurveyDoctrine $survey = null;

    #[ORM\OneToMany(targetEntity: AttachmentDoctrine::class, mappedBy: 'post', cascade: ['remove', 'persist'])]
    private Collection $attachments;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $createdAt;

    #[ORM\Column(type: 'boolean')]
    private bool $modified;

    public function __construct()
    {
        $this->attachments = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getAuthor(): ?UserDoctrine
    {
        return $this->author;
    }

    public function setAuthor(?UserDoctrine $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getChannel(): ChannelDoctrine
    {
        return $this->channel;
    }

    public function setChannel(ChannelDoctrine $channel): self
    {
        $this->channel = $channel;
        return $this;
    }

    public function getSurvey(): ?SurveyDoctrine
    {
        return $this->survey;
    }

    public function setSurvey(?SurveyDoctrine $survey): self
    {
        $this->survey = $survey;
        return $this;
    }

    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(AttachmentDoctrine $attachment): self
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments->add($attachment);
            $attachment->setPost($this);
        }
        return $this;
    }

    public function removeAttachment(AttachmentDoctrine $attachment): self
    {
        if ($this->attachments->removeElement($attachment)) {
            if ($attachment->getPost() === $this) {
                $attachment->setPost(null);
            }
        }
        return $this;
    }

    public function setAttachments(Collection $attachments): self
    {
        $this->attachments = $attachments;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function isModified(): bool
    {
        return $this->modified;
    }

    public function setIsModified(bool $isModified): self
    {
        $this->modified = $isModified;
        return $this;
    }
}