<?php declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Psr\Http\Message\ServerRequestInterface;

use Twig\Environment;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\HtmlResponse;

use Alumni\Application\UseCase\UploadPostAttachment\UploadPostAttachmentUseCase;
use Alumni\Application\UseCase\UploadPostAttachment\UploadPostAttachmentRequest;

use Alumni\Application\UseCase\UploadPostPicture\UploadPostPictureUseCase;
use Alumni\Application\UseCase\UploadPostPicture\UploadPostPictureRequest;

use Alumni\Application\UseCase\UploadPost\UploadPostUseCase;
use Alumni\Application\UseCase\UploadPost\UploadPostRequest;

use Alumni\Application\UseCase\UpdatePost\UpdatePostUseCase;
use Alumni\Application\UseCase\UpdatePost\UpdatePostRequest;

use Alumni\Application\UseCase\DeletePost\DeletePostUseCase;
use Alumni\Application\UseCase\DeletePost\DeletePostRequest;

use Alumni\Application\UseCase\RefreshChannelPosts\RefreshChannelPostsUseCase;
use Alumni\Application\UseCase\RefreshChannelPosts\RefreshChannelPostsRequest;

class ChannelPostController
{
    public function __construct(
        private readonly UploadPostAttachmentUseCase $uploadPostAttachment,
        private readonly UploadPostPictureUseCase $uploadPostPicture,
        private readonly UploadPostUseCase $uploadPost,
        private readonly UpdatePostUseCase $updatePost,
        private readonly DeletePostUseCase $deletePost,
        private readonly RefreshChannelPostsUseCase $refreshChannelPosts,
        private readonly Environment $twig
    ) {}

    public function addAttachment(ServerRequestInterface $request): JsonResponse
    {
        $requestDTO = new UploadPostAttachmentRequest($request->getUploadedFiles()['file']);

        $response = $this->uploadPostAttachment->execute($requestDTO);

        return new JsonResponse([
            'success' => $response->uploadStatus,
            'file' => [
                'url' => $response->file->url,
                'name' => $response->file->name
            ]
        ], $response->uploadStatus ? 200 : 500);
    }

    public function addPicture(ServerRequestInterface $request): JsonResponse
    {
        $requestDTO = new UploadPostPictureRequest($request->getUploadedFiles()['image']);

        $response = $this->uploadPostPicture->execute($requestDTO);

        return new JsonResponse([
            'success' => $response->uploadStatus,
            'file' => [
                'url' => $response->picture->url,
                'name' => $response->picture->name
            ]
        ], $response->uploadStatus ? 200 : 500);
    }

    public function send(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true) ?? [];

        $channelId = intval($requestBody['channelId']);
        $content = $requestBody['postContent'];

        $requestDTO = new UploadPostRequest($user['userId'], $channelId, $content);

        $response = $this->uploadPost->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg
        ], $response->status ? 200 : 500);
    }

    public function update(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true) ?? [];

        $channelId = intval($requestBody['channelId']);
        $postId = intval($requestBody['postId']);
        $content = $requestBody['postContent'];

        $requestDTO = new UpdatePostRequest($user['userId'], $channelId, $postId, $content);

        $response = $this->updatePost->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg
        ], $response->status ? 200 : 500);
    }

    public function remove(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true) ?? [];

        $requestDTO = new DeletePostRequest($user['userId'], intval($requestBody['channelId']), intval($requestBody['postId']));

        $response = $this->deletePost->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg
        ], $response->status ? 200 : 500);
    }

    public function getAll(ServerRequestInterface $request): HtmlResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true) ?? [];

        $requestDTO = new RefreshChannelPostsRequest($user['userId'], intval($requestBody['channelId']));
        $response = $this->refreshChannelPosts->execute($requestDTO);

        return new HtmlResponse($this->twig->render('./Components/ChannelPostsList.twig', [
            'posts' => $response->posts,
            'user' => $response->user
        ]), $response->status);

    }
}