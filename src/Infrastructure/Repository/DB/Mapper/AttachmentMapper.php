<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\Attachment;
use Alumni\Domain\Entity\ChannelPost;
use Alumni\Infrastructure\Entity\AttachmentDoctrine;
use Alumni\Infrastructure\Entity\ChannelPostDoctrine;

class AttachmentMapper
{
    public function __construct() {}

    public function toDomain(
        AttachmentDoctrine $attachmentDoctrine,
        ChannelPost $post
    ): Attachment {
        return new Attachment(
            id: $attachmentDoctrine->getId(),
            filename: $attachmentDoctrine->getFilename(),
            originalName: $attachmentDoctrine->getOriginalName(),
            mimeType: $attachmentDoctrine->getMimeType(),
            fileSize: $attachmentDoctrine->getFileSize(),
            filePath: $attachmentDoctrine->getFilePath(),
            uploadedAt: $attachmentDoctrine->getUploadedAt(),
            post: $post
        );
    }

    public function toDoctrine(
        Attachment $attachment,
        ChannelPostDoctrine $post
    ): AttachmentDoctrine {
        $attachmentDoctrine = new AttachmentDoctrine();
        $attachmentDoctrine->setFilename($attachment->filename);
        $attachmentDoctrine->setOriginalName($attachment->originalName);
        $attachmentDoctrine->setMimeType($attachment->mimeType);
        $attachmentDoctrine->setFileSize($attachment->fileSize);
        $attachmentDoctrine->setFilePath($attachment->filePath);
        $attachmentDoctrine->setUploadedAt($attachment->uploadedAt);
        $attachmentDoctrine->setPost($post);
        
        return $attachmentDoctrine;
    }
}
