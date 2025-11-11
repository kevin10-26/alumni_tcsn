<?php declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Psr\Http\Message\ServerRequestInterface;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;

use Twig\Environment;

use Alumni\Application\UseCase\GetPortability\GetPortabilityRequest;
use Alumni\Application\UseCase\GetPortability\GetPortabilityUseCase;

class LegalController
{
    public function __construct(
        private readonly GetPortabilityUseCase $getPortability,
        private readonly Environment $twig
    ) {}

    public function portability(ServerRequestInterface $request): HtmlResponse
    {
        $user = $request->getAttribute('user')->token;

        $requestDTO = new GetPortabilityRequest($user['userId']);
        $response = $this->getPortability->execute($requestDTO);

        return new HtmlResponse($this->twig->render('./Components/PortabilityDocument.twig', [
            'file' => $response->pathToPortabilityFile
        ]), $response->status);
    }
}