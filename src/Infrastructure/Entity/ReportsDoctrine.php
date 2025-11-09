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

    #[ORM\Column(type: 'string', length: 255)]
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
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private UserDoctrine $author;

    #[ORM\OneToMany(targetEntity: ChannelPostDoctrine::class, mappedBy: 'reports')]
    private ?Collection $channelPost = null;

    #[ORM\OneToMany(targetEntity: ChannelDoctrine::class, mappedBy: 'reports')]
    private ?Collection $channel = null;

    #[ORM\OneToMany(targetEntity: UserDoctrine::class, mappedBy: 'reports')]
    private ?Collection $user = null;

    #[ORM\OneToMany(targetEntity: JobOfferDoctrine::class, mappedBy: 'reports')]
    private ?Collection $jobOffer = null;

    #[ORM\OneToMany(targetEntity: AttachmentsReportDoctrine::class, mappedBy: 'report_id', cascade: ['persist', 'remove'])]
    private ?Collection $attachments = null;

    public function __construct()
    {
        $this->channelPost = new ArrayCollection();
        $this->channel = new ArrayCollection();
        $this->user = new ArrayCollection();
        $this->jobOffer = new ArrayCollection();
        $this->attachments = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }
    
    public function getTopic(): string
    {
        return $this->topic;
    }

    public function setTopic(string $topic): self
    {
        $this->topic = $topic;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
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

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
    
    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
    
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getAuthor(): UserDoctrine
    {
        return $this->author;
    }

    public function setAuthor(UserDoctrine $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getChannelPost(): ?ChannelPostDoctrine
    {
        return $this->channelPost;
    }

    public function setChannelPost(?ChannelPostDoctrine $channelPost): self
    {
        $this->channelPost = $channelPost;

        return $this;
    }

    public function addChannelPost(ChannelPostDoctrine $channelPost): self
    {
        // Avoid duplicates
        if (!$this->channelPost->contains($channelPost)) {
            $this->channelPost->add($channelPost);
            // If bidirectional: $channelPost->setParent($this);
        }

        return $this;
    }

    public function removeChannelPost(ChannelPostDoctrine $channelPost): self
    {
        if ($this->channelPost->contains($channelPost)) {
            $this->channelPost->removeElement($channelPost);
            // If bidirectional: 
            // if ($channelPost->getParent() === $this) {
            //     $channelPost->setParent(null);
            // }
        }

        return $this;
    }

    public function getChannel(): ?ChannelDoctrine
    {
        return $this->channel;
    }

    public function setChannel(?ChannelDoctrine $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function addChannel(ChannelDoctrine $channel): self
    {
        if (!$this->channel->contains($channel)) {
            $this->channel->add($channel);
            // If bidirectional: $channel->setParent($this);
        }

        return $this;
    }

    public function removeChannel(ChannelDoctrine $channel): self
    {
        if ($this->channel->contains($channel)) {
            $this->channel->removeElement($channel);
            // If bidirectional:
            // if ($channel->getParent() === $this) {
            //     $channel->setParent(null);
            // }
        }

        return $this;
    }

    public function getUser(): ?UserDoctrine
    {
        return $this->user;
    }

    public function setUser(?UserDoctrine $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function addUser(UserDoctrine $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            // If bidirectional: $user->setParent($this);
        }

        return $this;
    }

    public function removeUser(UserDoctrine $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // If bidirectional:
            // if ($user->getParent() === $this) {
            //     $user->setParent(null);
            // }
        }

        return $this;
    }

    public function getJobOffer(): ?JobOfferDoctrine
    {
        return $this->jobOffer;
    }

    public function setJobOffer(?JobOfferDoctrine $jobOffer): self
    {
        $this->jobOffer = $jobOffer;

        return $this;
    }

    public function addJobOffer(JobOfferDoctrine $jobOffer): self
    {
        if (!$this->jobOffer->contains($jobOffer)) {
            $this->jobOffer->add($jobOffer);
            // If bidirectional: $jobOffer->setParent($this);
        }

        return $this;
    }

    public function removeJobOffer(JobOfferDoctrine $jobOffer): self
    {
        if ($this->jobOffer->contains($jobOffer)) {
            $this->jobOffer->removeElement($jobOffer);
            // If bidirectional:
            // if ($jobOffer->getParent() === $this) {
            //     $jobOffer->setParent(null);
            // }
        }

        return $this;
    }


    /**
     * Gets the collection of attachments associated with this report.
     * 
     * @return Collection<AttachmentsReportDoctrine>|null The collection of attachments, or null if not initialized
     */
    public function getAttachments(): ?Collection
    {
        return $this->attachments;
    }

    /**
     * Adds an attachment to this report.
     * 
     * This method ensures the attachment is added to the collection and
     * sets the bidirectional relationship by setting the attachment's report reference.
     * 
     * @param AttachmentsReportDoctrine $attachment The attachment to add
     * @return self Returns $this for method chaining
     */
    public function addAttachment(AttachmentsReportDoctrine $attachment): self
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments->add($attachment);
            $attachment->setReportId($this);
        }
        return $this;
    }

    /**
     * Removes an attachment from this report.
     * 
     * This method removes the attachment from the collection and clears
     * the bidirectional relationship by setting the attachment's report reference to null.
     * 
     * @param AttachmentsReportDoctrine $attachment The attachment to remove
     * @return self Returns $this for method chaining
     */
    public function removeAttachment(AttachmentsReportDoctrine $attachment): self
    {
        if ($this->attachments->removeElement($attachment)) {
            if ($attachment->getReportId() === $this) {
                $attachment->setReportId(null);
            }
        }
        return $this;
    }

    /**
     * Sets the complete collection of attachments for this report.
     * 
     * Note: This method replaces the entire collection. For adding individual
     * attachments, use addAttachment() instead.
     * 
     * @param Collection $attachments The collection of attachments to set
     * @return self Returns $this for method chaining
     */
    public function setAttachments(Collection $attachments): self
    {
        $this->attachments = $attachments;
        return $this;
    }
}