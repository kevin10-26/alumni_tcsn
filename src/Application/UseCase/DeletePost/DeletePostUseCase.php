<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\DeletePost;

use Alumni\Domain\Repository\DB\ChannelPostRepositoryInterface;
use Alumni\Domain\Repository\File\PostChannelFileRepositoryInterface;

class DeletePostUseCase
{
    public function __construct(
        private readonly ChannelPostRepositoryInterface $channelPostRepository,
        private readonly PostChannelFileRepositoryInterface $postChannelFileRepository,
    ) {}

    public function execute(DeletePostRequest $request): DeletePostResponse
    {
        $post = $this->channelPostRepository->getPostBy(['id' => $request->postId]);
        if ($post->channel->id === $request->userId || $post->author->id === $request->userId)
        {
            $dbCleared = $this->channelPostRepository->removePost($request->postId);

            if (count($post->attachments) > 0)
            {
                foreach ($post->attachments as $document)
                {
                    $this->postChannelFileRepository->remove($post->channel->id, $document->filePath);
                }
                $filesDeleted = true;
            }

            $deletion = $dbCleared && (isset($filesDeleted) && $filesDeleted || !isset($filesDeleted));
        }

        return new DeletePostResponse(
            status: isset($deletion) && $deletion ? 200 : 500,
            msg: isset($deletion) && $deletion ? 'La publication a bien été supprimée' : 'La publication n\'a pas pu être supprimée'
        );
    }
}