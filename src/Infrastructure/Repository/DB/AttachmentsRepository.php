<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;

use Alumni\Infrastructure\Repository\DB\Mapper\AttachmentMapper;
use Alumni\Infrastructure\Repository\DB\Mapper\ChannelPostMapper;
use Alumni\Infrastructure\Entity\AttachmentDoctrine;

use Alumni\Domain\Entity\Attachment;
use Alumni\Domain\Repository\DB\AttachmentsRepositoryInterface;

/**
 * Repository implementation for managing Attachment entities in the database.
 * 
 * This repository handles all database operations for post attachments, including
 * retrieval by various criteria (all, by condition, by post, by user).
 */
class AttachmentsRepository implements AttachmentsRepositoryInterface
{
    /**
     * Creates a new instance of AttachmentsRepository.
     * 
     * @param EntityManagerInterface $em Doctrine entity manager for database operations
     * @param AttachmentMapper $fileMapper Mapper for converting Attachment entities
     * @param ChannelPostMapper $postMapper Mapper for converting ChannelPost entities
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly AttachmentMapper $fileMapper,
        private readonly ChannelPostMapper $postMapper
    ) {}

    /**
     * Retrieves all attachments from all posts.
     * 
     * Note: Attachments without an associated post are skipped.
     * 
     * @return array<Attachment> Array of all attachments as domain entities
     */
    public function getAll(): array
    {
        $attachmentsDoctrine = $this->em->getRepository(AttachmentDoctrine::class)->findAll();
        $attachments = [];

        foreach ($attachmentsDoctrine as $attachment)
        {
            if ($attachment->getPost() === null) {
                continue;
            }
            $post = $this->postMapper->toDomain($attachment->getPost());
            $attachments[] = $this->fileMapper->toDomain($attachment, $post);
        }

        return $attachments;
    }

    /**
     * Retrieves a single attachment by the given conditions.
     * 
     * @param array<string, mixed> $condition Associative array of field => value pairs to search for
     * @return Attachment The found attachment as a domain entity
     * @throws \RuntimeException If the attachment has no associated post
     */
    public function getBy(array $condition): Attachment
    {
        $attachmentDoctrine = $this->em->getRepository(AttachmentDoctrine::class)->findOneBy($condition);

        if ($attachmentDoctrine->getPost() === null) {
            throw new \RuntimeException('Attachment must have a post');
        }
        $post = $this->postMapper->toDomain($attachmentDoctrine->getPost());

        return $this->fileMapper->toDomain($attachmentDoctrine, $post);
    }

    /**
     * Retrieves all attachments for a specific channel.
     * 
     * @param int $channelId The ID of the channel.
     * @return array<Attachment> Array of attachments for the channel as domain entities
     */
    public function getChannelAttachments(int $channelId): array
    {
        $attachmentsDoctrine = $this->em->getRepository(AttachmentDoctrine::class)
            ->createQueryBuilder('a')
            ->join('a.post', 'p')
            ->where('IDENTITY(p.channel) = :channelId')
            ->setParameter('channelId', $channelId)
            ->getQuery()
            ->getResult();

        $attachments = [];
        foreach ($attachmentsDoctrine as $entry)
        {
            if ($entry->getPost() === null) {
                continue;
            }
            $post = $this->postMapper->toDomain($entry->getPost());
            $attachments[] = $this->fileMapper->toDomain($entry, $post);
        }

        return $attachments;
    }

    /**
     * Retrieves all attachments for a specific post.
     * 
     * @param int $postId The ID of the post
     * @param int $channelId The ID of the post's channel
     * @return array<Attachment> Array of attachments for the post as domain entities
     */
    public function getPostAttachments(int $postId, int $channelId): array
    {
        $attachmentsDoctrine = $this->em->getRepository(AttachmentDoctrine::class)
            ->createQueryBuilder('a')
            ->join('a.post', 'p')
            ->where('IDENTITY(a.post) = :postId')
            ->andWhere('IDENTITY(p.channel) = :channelId')
            ->setParameter('postId', $postId)
            ->setParameter('channelId', $channelId)
            ->getQuery()
            ->getResult();

        $attachments = [];
        foreach ($attachmentsDoctrine as $entry)
        {
            if ($entry->getPost() === null) {
                continue;
            }
            $post = $this->postMapper->toDomain($entry->getPost());
            $attachments[] = $this->fileMapper->toDomain($entry, $post);
        }

        return $attachments;
    }

    /**
     * Retrieves all attachments from posts created by a specific user.
     * 
     * This method uses a JOIN query to find attachments where the post's author
     * matches the given user ID.
     * 
     * @param int $userId The ID of the user
     * @return array<Attachment> Array of attachments from the user's posts as domain entities
     */
    public function getUserAttachments(int $userId): array
    {
        $attachmentsDoctrine = $this->em->getRepository(AttachmentDoctrine::class)
            ->createQueryBuilder('a')
            ->join('a.post', 'p')
            ->where('IDENTITY(p.author) = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
        $attachments = [];

        foreach ($attachmentsDoctrine as $attachment)
        {
            if ($attachment->getPost() === null) {
                continue;
            }
            $post = $this->postMapper->toDomain($attachment->getPost());
            $attachments[] = $this->fileMapper->toDomain($attachment, $post);
        }

        return $attachments;
    }

    public function removeFile(string $filePath, int $channelId): bool
    {
        $entry = $this->em->getRepository(AttachmentDoctrine::class)->findOneBy(['filePath' => $filePath]);

        if (!is_null($entry))
        {
            $this->em->remove($entry);
        }
        $this->em->flush();

        return true;
    }
}