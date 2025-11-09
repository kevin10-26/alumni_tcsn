<?php declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Psr\Http\Message\ServerRequestInterface;

use Laminas\Diactoros\Response\HtmlResponse;

use Twig\Environment;

use Alumni\Application\UseCase\GetAdminDashboard\GetAdminDashboardUseCase;

use Alumni\Application\UseCase\GetAdminDashboard\GetAdminDashboardRequest;

class UserController
{
    public function __construct(
        private readonly GetAdminDashboardUseCase $getAdminDashboard,
        private readonly Environment $twig
    ) {}

    public function dashboard(ServerRequestInterface $request): HtmlResponse
    {
        $user = $request->getAttribute('user')->token;

        $requestDTO = new GetAdminDashboardRequest($user['userId']);
        
        $response = $this->getAdminDashboard->execute($requestDTO);

        return new HtmlResponse($this->twig->render('./Dashboard.twig', [
            'user' => $response->user,
            'jobOffers' => $response->jobOffers,
            'savedOffers' => $response->savedOffers
        ]), $response->status);
    }
}