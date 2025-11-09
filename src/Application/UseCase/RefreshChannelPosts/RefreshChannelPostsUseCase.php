<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RefreshChannelPosts;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\ChannelPostRepositoryInterface;

class RefreshChannelPostsUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly ChannelPostRepositoryInterface $channelPostRepository
    ) {}

    public function execute(RefreshChannelPostsRequest $requestDTO): RefreshChannelPostsResponse
    {
        $user = $this->userRepository->getBy(['id' => $requestDTO->userId]);
        $posts = $this->channelPostRepository->getAllChannelPosts($requestDTO->channelId);
        
        return new RefreshChannelPostsResponse(
            status: ($user && $posts) ? 200 : 500,
            user: $user,
            posts: $posts
        );
    }
}