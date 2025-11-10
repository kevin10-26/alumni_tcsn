<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\ChannelPost;
use Alumni\Infrastructure\Entity\ChannelPostDoctrine;
use Alumni\Infrastructure\Entity\AttachmentDoctrine;

use Doctrine\Common\Collections\ArrayCollection;

class ChannelPostMapper
{
    public function __construct(
        private readonly UserMapper $userMapper,
        private readonly ChannelMapper $channelMapper,
        private readonly AttachmentMapper $attachmentMapper,
        private readonly SurveyMapper $surveyMapper
    ) {}

    public function toDomain(ChannelPostDoctrine $channelPostDoctrine): ChannelPost
    {
        // First create the post domain object without attachments to avoid circular dependency
        $post = new ChannelPost(
            id: $channelPostDoctrine->getId(),
            content: $channelPostDoctrine->getContent(),
            author: $this->userMapper->toDomain($channelPostDoctrine->getAuthor()),
            channel: $this->channelMapper->toDomain($channelPostDoctrine->getChannel()),
            modified: $channelPostDoctrine->isModified(),
            survey: $channelPostDoctrine->getSurvey() ? $this->surveyMapper->toDomain($channelPostDoctrine->getSurvey()) : null,
            attachments: [],
            createdAt: $channelPostDoctrine->getCreatedAt()
        );

        // Now map attachments, passing the already-converted post
        $attachments = [];
        foreach ($channelPostDoctrine->getAttachments() as $attachment) {
            $attachments[] = $this->attachmentMapper->toDomain($attachment, $post);
        }

        // Return a new ChannelPost with attachments
        return new ChannelPost(
            id: $post->id,
            content: $post->content,
            author: $post->author,
            channel: $post->channel,
            survey: $post->survey,
            modified: $post->modified,
            attachments: $attachments,
            createdAt: $post->createdAt,
        );
    }

    public function toDoctrine(ChannelPost $channelPost): ChannelPostDoctrine
    {
        $channelPostDoctrine = new ChannelPostDoctrine();
        $channelPostDoctrine->setContent($channelPost->content);
        $channelPostDoctrine->setAuthor($this->userMapper->toDoctrine($channelPost->author));
        $channelPostDoctrine->setChannel($this->channelMapper->toDoctrine($channelPost->channel));
        $channelPostDoctrine->setCreatedAt($channelPost->createdAt);

        if ($channelPost->survey) {
            $channelPostDoctrine->setSurvey($this->surveyMapper->toDoctrine($channelPost->survey));
        }

        foreach ($channelPost->attachments as $attachment) {
            $channelPostDoctrine->addAttachment($this->attachmentMapper->toDoctrine($attachment, $channelPostDoctrine));
        }

        return $channelPostDoctrine;
    }

    /**
     * @param array{files?: array, pictures?: array}|null $attachments
     * @return ArrayCollection<int, AttachmentDoctrine>
     */
    public function attachmentsToDoctrine(?array $attachments, ChannelPostDoctrine $post): ArrayCollection
    {
        $attachmentsCollection = new ArrayCollection();

        if ($attachments === null) {
            return $attachmentsCollection;
        }

        $allFiles = array_merge(
            $attachments['files'] ?? [],
            $attachments['pictures'] ?? []
        );

        foreach ($allFiles as $fileData) {
            $attachment = $this->createAttachmentFromFileData($fileData, $post);
            $attachmentsCollection->add($attachment);
        }

        return $attachmentsCollection;
    }

    private function createAttachmentFromFileData(array $fileData, ChannelPostDoctrine $post): AttachmentDoctrine
    {
        $attachment = new AttachmentDoctrine();
        
        // Extract filename from URL (remove query parameters if any)
        $url = $fileData['url'] ?? '';
        $urlPath = parse_url($url, PHP_URL_PATH);
        $filename = basename($urlPath);
        
        // Extract original name from poolLocation or use filename
        $originalName = $filename;
        if (isset($fileData['poolLocation'])) {
            $poolPath = parse_url($fileData['poolLocation'], PHP_URL_PATH);
            $originalName = basename($poolPath);
        }
        $pathToFile = $_ENV['APP_DIR'] . 'public' . $poolPath ?? $urlPath;
        
        // Set attachment properties
        $attachment->setFilename($filename);
        $attachment->setOriginalName($originalName);
        $attachment->setMimeType(mime_content_type($pathToFile) ?? 'application/octet-stream');
        $attachment->setFileSize(filesize($pathToFile) ?? 0);
        $attachment->setFilePath($url);
        $attachment->setUploadedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $attachment->setPost($post);
        
        return $attachment;
    }
}