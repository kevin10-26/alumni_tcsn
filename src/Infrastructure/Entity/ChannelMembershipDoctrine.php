<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ChannelMembershipDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: UserDoctrine::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?UserDoctrine $user = null;

    #[ORM\ManyToOne(targetEntity: ChannelDoctrine::class, inversedBy: 'members')]
    #[ORM\JoinColumn(name: "channel_id", referencedColumnName: "id")]
    private ChannelDoctrine $channel;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $joinedAt;

    #[ORM\Column(type: 'string', length: 50)]
    private string $role = 'member';

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): UserDoctrine
    {
        return $this->user;
    }

    public function setUser(UserDoctrine $user): self
    {
        $this->user = $user;
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

    public function getJoinedAt(): \DateTime
    {
        return $this->joinedAt;
    }

    public function setJoinedAt(\DateTime $joinedAt): self
    {
        $this->joinedAt = $joinedAt;
        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }
}