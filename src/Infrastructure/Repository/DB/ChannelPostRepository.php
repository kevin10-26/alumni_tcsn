<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;
use Alumni\Infrastructure\Repository\DB\Mapper\ChannelPostMapper;
use Alumni\Infrastructure\Entity\ChannelPostDoctrine;
use Alumni\Infrastructure\Entity\FilePoolDoctrine;
use Alumni\Infrastructure\Entity\UserDoctrine;
use Alumni\Infrastructure\Entity\ChannelDoctrine;

use Alumni\Domain\Repository\DB\ChannelPostRepositoryInterface;
use Alumni\Domain\Entity\ChannelPost;

use Alumni\Domain\Entity\File;

/**
 * Repository implementation for managing ChannelPost entities in the database.
 * 
 * This repository handles all database operations for channel posts, including
 * retrieval, creation, and file pool management for post attachments.
 */
class ChannelPostRepository implements ChannelPostRepositoryInterface
{
    /**
     * Creates a new instance of ChannelPostRepository.
     * 
     * @param EntityManagerInterface $em Doctrine entity manager for database operations
     * @param ChannelPostMapper $postMapper Mapper for converting between domain and Doctrine entities
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ChannelPostMapper $postMapper
    ) {}

    /**
     * Retrieves all posts from all channels.
     * 
     * @return array<ChannelPost> Array of all posts as domain entities
     */
    public function getAllPosts(): array
    {
        $postsDoctrine = $this->em->getRepository(ChannelPostDoctrine::class)->findAll();
        $posts = [];

        foreach ($postsDoctrine as $post)
        {
            $posts[] = $this->postMapper->toDomain($post);
        }

        return $posts;
    }

    /**
     * Retrieves all posts for a specific channel, ordered by ID in descending order (newest first).
     * 
     * @param int $channelId The ID of the channel
     * @return array<ChannelPost> Array of posts for the channel as domain entities
     */
    public function getAllChannelPosts(int $channelId): array
    {
        $postsDoctrine = $this->em->getRepository(ChannelPostDoctrine::class)->findBy(['channel' => $channelId], ['id' => 'DESC']);
        $posts = [];

        foreach ($postsDoctrine as $post)
        {
            $posts[] = $this->postMapper->toDomain($post);
        }

        return $posts;
    }

    /**
     * Retrieves all posts created by a specific user.
     * 
     * @param int $userId The ID of the user/author
     * @return array<ChannelPost> Array of posts created by the user as domain entities
     */
    public function getPostsOfAuthor(int $userId): array
    {
        $postsDoctrine = $this->em->getRepository(ChannelPostDoctrine::class)->findBy(['author' => $userId]);
        $posts = [];

        foreach ($postsDoctrine as $post)
        {
            $posts[] = $this->postMapper->toDomain($post);
        }

        return $posts;
    }

    /**
     * Retrieves a single post by the given conditions.
     * 
     * @param array<string, mixed> $condition Associative array of field => value pairs to search for
     * @return ChannelPost The found post as a domain entity
     */
    public function getPostBy(array $condition): ChannelPost
    {
        $postDoctrine = $this->em->getRepository(ChannelPostDoctrine::class)->findOneBy($condition);

        return $this->postMapper->toDomain($postDoctrine);
    }

    /**
     * @deprecated
     */
    public function getPostWithAttachments(int $channelId): array
    {
        $queryPosts = $this->em->createQuery(
            'SELECT DISTINCT cp
             FROM Alumni\Infrastructure\Entity\ChannelPostDoctrine cp
             JOIN cp.attachments a
             WHERE cp.channel = :channel'
        )->setParameter('channel', $channelId);
        $postsDoctrine = $queryPosts->getResult();

        $posts = [];

        foreach ($postsDoctrine as $post)
        {
            $posts[] = $this->postMapper->toDomain($post);
        }

        return $posts;
    }
    
    public function getPostsOfAuthorPerChannel(int $userId, int $channelId): array
    {
        $queryPosts = $this->em->createQuery(
            'SELECT cp
            FROM Alumni\Infrastructure\Entity\ChannelPostDoctrine cp
            WHERE IDENTITY(cp.channel) = :channel
            AND IDENTITY(cp.author) = :author'
        )
        ->setParameter('channel', $channelId)
        ->setParameter('author', $userId);

        $userPostsDoctrine = $queryPosts->getResult();

        $userPosts = [];

        foreach($userPostsDoctrine as $post)
        {
            $userPosts[] = $this->postMapper->toDomain($post);
        }
        return $userPosts;
    }

    /**
     * Adds a file to the file pool for temporary storage before attachment to a post.
     * 
     * @param File $file The file entity to add to the pool
     * @return bool Always returns true on success
     */
    public function addToPool(File $file): bool
    {
        $fileDoctrine = new FilePoolDoctrine();
        $fileDoctrine->setClientFilename($file->name);
        $fileDoctrine->setPoolName($file->poolName);
        $fileDoctrine->setMimeType($file->mimeType);
        
        $this->em->persist($fileDoctrine);
        $this->em->flush();

        return true;
    }

    /**
     * Creates a new channel post with optional attachments.
     * 
     * This method creates a new post in the specified channel, associates it with
     * the author, and optionally processes file attachments. The content is stored
     * as JSON-encoded data.
     * 
     * @param int $userId The ID of the user creating the post
     * @param int $channelId The ID of the channel where the post will be created
     * @param array<string, mixed> $content The post content (will be JSON-encoded)
     * @param array<string, array<int, array<string, mixed>>>|null $attachments Optional array containing 'files' and/or 'pictures' with file data
     * @return bool Always returns true on success
     */
    public function upload(
        int $userId,
        int $channelId,
        array $content,
        ?array $attachments
    ): bool
    {
        $post = new ChannelPostDoctrine();
        $post->setAuthor($this->em->find(UserDoctrine::class, $userId));
        $post->setChannel($this->em->find(ChannelDoctrine::class, $channelId));
        $post->setContent(json_encode($content));
        $post->setAttachments($this->postMapper->attachmentsToDoctrine($attachments, $post));
        $post->setCreatedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $post->setIsModified(false);

        $this->em->persist($post);
        $this->em->flush();

        return true;

    }

    public function update(
        int $userId,
        int $channelId,
        int $postId,
        array $content,
        ?array $attachments
    ): bool
    {
        $post = $this->em->find(ChannelPostDoctrine::class, $postId);
        if (is_null($post))
        {
            return false;
        }
        
        $post->setContent(json_encode($content));

        $post->setAttachments($this->postMapper->attachmentsToDoctrine($attachments, $post));
        $post->setIsModified(true);

        $this->em->persist($post);
        $this->em->flush();

        return true;

    }

    /**
     * Removes files from the file pool after they have been processed.
     * 
     * This method extracts pool names from document locations and removes
     * the corresponding entries from the file pool.
     * 
     * @param array<int, array<int, array<string, string>>> $documents Array of document arrays, each containing 'poolLocation' keys
     * @return bool Always returns true on success
     */
    public function removeFromPool(array $documents): bool
    {
        foreach($documents as $poolElement)
        {
            for ($i = 0; $i < count($poolElement); $i++)
            {
                $poolName = strstr(substr(strrchr($poolElement[$i]['poolLocation'], '/'), 1), '.', true);
                $entry = $this->em->getRepository(FilePoolDoctrine::class)->findOneBy(['poolName' => $poolName]);

                if (!is_null($entry))
                {
                    $this->em->remove($entry);
                }
            }
        }

        return true;
    }

    public function removePost(int $postId): bool
    {
        $post = $this->em->find(ChannelPostDoctrine::class, $postId);
        if (!is_null($post))
        {
            $this->em->remove($post);
            $this->em->flush();
            return true;
        }

        return false;
    }
}