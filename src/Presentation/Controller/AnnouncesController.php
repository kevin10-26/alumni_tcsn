<?php declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Psr\Http\Message\ServerRequestInterface;

use Laminas\Diactoros\Response\HtmlResponse;

use Twig\Environment;

use Alumni\Application\UseCase\ListAllAnnounces\ListAllAnnouncesUseCase;
use Alumni\Application\UseCase\ListAllAnnounces\ListAllAnnouncesRequest;

class AnnouncesController
{
    public function __construct(
        private readonly ListAllAnnouncesUseCase $listAnnounces,
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
}