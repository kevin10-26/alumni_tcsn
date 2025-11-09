<?php declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Psr\Http\Message\ServerRequestInterface;

use Laminas\Diactoros\Response\HtmlResponse;

use Twig\Environment;

use Alumni\Application\UseCase\Home\HomeUseCase;
use Alumni\Application\UseCase\Home\HomeRequest;

class HomeController
{
    public function __construct(
        private readonly HomeUseCase $homeUseCase,
        private readonly Environment $twig
    ) {}

    public function index(ServerRequestInterface $request): HtmlResponse
    {
        $user = $request->getAttribute('user')->token;

        $request = new HomeRequest($user['userId']);
        $response = $this->homeUseCase->execute($request);

        return new HtmlResponse($this->twig->render('home/Index.twig', [
            'userData' => $response->user,
            'events' => $response->events
        ]));
    }
}