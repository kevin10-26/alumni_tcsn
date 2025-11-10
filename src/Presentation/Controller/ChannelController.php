<?php declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Psr\Http\Message\ServerRequestInterface;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;

use Twig\Environment;

use Alumni\Application\UseCase\ListAllChannels\ListAllChannelsUseCase;
use Alumni\Application\UseCase\ListAllChannels\ListAllChannelsRequest;

use Alumni\Application\UseCase\GetChannel\GetChannelUseCase;
use Alumni\Application\UseCase\GetChannel\GetChannelRequest;

use Alumni\Application\UseCase\QuitChannel\QuitChannelUseCase;
use Alumni\Application\UseCase\QuitChannel\QuitChannelRequest;

use Alumni\Application\UseCase\JoinChannel\JoinChannelUseCase;
use Alumni\Application\UseCase\JoinChannel\JoinChannelRequest;

use Alumni\Application\UseCase\UpdateChannelData\UpdateChannelDataUseCase;
use Alumni\Application\UseCase\UpdateChannelData\UpdateChannelDataRequest;

use Alumni\Application\UseCase\UpdateChannelThumbnail\UpdateChannelThumbnailUseCase;
use Alumni\Application\UseCase\UpdateChannelThumbnail\UpdateChannelThumbnailRequest;

use Alumni\Application\UseCase\RemoveChannel\RemoveChannelUseCase;
use Alumni\Application\UseCase\RemoveChannel\RemoveChannelRequest;

class ChannelController
{
    public function __construct(
        private readonly ListAllChannelsUseCase $listChannels,
        private readonly GetChannelUseCase $getChannel,
        private readonly QuitChannelUseCase $quitChannel,
        private readonly JoinChannelUseCase $joinChannel,
        private readonly updateChannelDataUseCase $updateChannelData,
        private readonly updateChannelThumbnailUseCase $updateChannelThumbnail,
        private readonly RemoveChannelUseCase $removeChannel,
        private readonly Environment $twig
    ) {}

    public function list(ServerRequestInterface $request): HtmlResponse
    {
        $user = $request->getAttribute('user')->token;

        $requestDTO = new ListAllChannelsRequest($user['userId']);
        
        $response = $this->listChannels->execute($requestDTO);

        return new HtmlResponse($this->twig->render('ChannelsList.twig', [
            'channels' => $response->channels,
            'userChannels' => $response->userChannels
        ]), $response->status);
    }

    public function get(ServerRequestInterface $request): HtmlResponse
    {
        $user = $request->getAttribute('user')->token;
        $channelId = intval($request->getAttribute('channelId'));

        $requestDTO = new GetChannelRequest($user['userId'], $channelId);
        
        $response = $this->getChannel->execute($requestDTO);

        return new HtmlResponse($this->twig->render('ChannelPage.twig', [
            'channel' => $response->channel,
            'posts' => $response->posts,
            'user' => $response->user,
            'attachments' => $response->attachments,
            'members' => $response->members
        ]), $response->status);
    }

    public function updateChannelData(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;
        $raw = (string) $request->getBody();

        $requestBody = json_decode($raw, true) ?? [];

        $requestDTO = new UpdateChannelDataRequest($user['userId'], intval($requestBody['targetedChannel']), $requestBody['field'], $requestBody['value']);
        
        $response = $this->updateChannelData->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg
        ], $response->status);
    }

    public function updateChannelThumbnail(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;

        $requestDTO = new UpdateChannelThumbnailRequest($user['userId'], intval($request->getParsedBody()['targetedChannel']), $request->getUploadedFiles()['file']);
        
        $response = $this->updateChannelThumbnail->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg,
            'state' => $response->status === 200 ? 'success' : 'error',
            'relativePath' => $response->thumbnailPath
        ], $response->status);
    }

    public function join(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;
        $raw = (string) $request->getBody();

        $requestBody = json_decode($raw, true) ?? [];

        $requestDTO = new JoinChannelRequest(intval($requestBody['targetedChannel']), $user['userId']);
        
        $response = $this->joinChannel->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'channelId' => $response->channelId
        ], $response->status);
    }

    public function quit(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;
        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true) ?? [];

        $requestDTO = new QuitChannelRequest($user['userId'], intval($requestBody['targetedChannel']));
        
        $response = $this->quitChannel->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg
        ], $response->status);
    }

    public function remove(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;
        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true) ?? [];

        $requestDTO = new RemoveChannelRequest($user['userId'], intval($requestBody['targetedChannel']), $requestBody['userPassword']);
        
        $response = $this->removeChannel->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg,
            'channelHasBeenRemoved' => $response->channelHasBeenRemoved
        ], $response->status);
    }
}