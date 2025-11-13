<?php declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Psr\Http\Message\ServerRequestInterface;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;

use Twig\Environment;

use Alumni\Application\UseCase\ListAllAnnounces\ListAllAnnouncesUseCase;
use Alumni\Application\UseCase\ListAllAnnounces\ListAllAnnouncesRequest;

use Alumni\Application\UseCase\UploadAnnounce\UploadAnnounceUseCase;
use Alumni\Application\UseCase\UploadAnnounce\UploadAnnounceRequest;

use Alumni\Application\UseCase\EditAnnounce\EditAnnounceUseCase;
use Alumni\Application\UseCase\EditAnnounce\EditAnnounceRequest;

use Alumni\Application\UseCase\RemoveAnnounce\RemoveAnnounceUseCase;
use Alumni\Application\UseCase\RemoveAnnounce\RemoveAnnounceRequest;

class AnnouncesController
{
    public function __construct(
        private readonly ListAllAnnouncesUseCase $listAnnounces,
        private readonly UploadAnnounceUseCase $uploadAnnounce,
        private readonly EditAnnounceUseCase $editAnnounce,
        private readonly RemoveAnnounceUseCase $removeAnnounce,
        private readonly Environment $twig
    ) {}

    public function list(ServerRequestInterface $request): HtmlResponse
    {
        $user = $request->getAttribute('user')->token;

        $requestDTO = new ListAllAnnouncesRequest($user['userId']);
        $response = $this->listAnnounces->execute($requestDTO);

        return new HtmlResponse($this->twig->render('AnnouncesList.twig', [
            'announces' => $response->announces,
        ]), $response->status);
    }

    public function create(ServerRequestInterface $request): RedirectResponse
    {
        $user = $request->getAttribute('user')->token;

        $requestBody = $request->getParsedBody();
        
        $requestDTO = new UploadAnnounceRequest($user['userId'], $requestBody['title'], $requestBody['content']);
        $response = $this->uploadAnnounce->execute($requestDTO);

        return new RedirectResponse($_ENV['APP_URL'] . 'backoffice');
    }

    public function edit(ServerRequestInterface $request): RedirectResponse
    {
        $user = $request->getAttribute('user')->token;

        $requestBody = $request->getParsedBody();
        
        $requestDTO = new EditAnnounceRequest($user['userId'], $requestBody['title'], $requestBody['content'], intval($requestBody['id']));
        $response = $this->editAnnounce->execute($requestDTO);

        return new RedirectResponse($_ENV['APP_URL'] . 'backoffice');
    }

    public function remove(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true);

        $requestDTO = new RemoveAnnounceRequest($user['userId'], $requestBody['announceId']);
        $response = $this->removeAnnounce->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg
        ], $response->status);
    }
}