<?php declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Psr\Http\Message\ServerRequestInterface;

use Laminas\Diactoros\Response\HtmlResponse;

use Twig\Environment;

use Alumni\Application\UseCase\ListAllJobOffers\ListAllJobOffersUseCase;

use Alumni\Application\UseCase\ListAllJobOffers\ListAllJobOffersRequest;

class JobsController
{
    public function __construct(
        private readonly ListAllJobOffersUseCase $listAllJobOffers,
        private readonly Environment $twig
    ) {}

    public function list(ServerRequestInterface $request): HtmlResponse
    {
        $user = $request->getAttribute('user')->token;

        $requestDTO = new ListAllJobOffersRequest($user['userId']);
        
        $response = $this->listAllJobOffers->execute($requestDTO);

        return new HtmlResponse($this->twig->render('./JobOffersList.twig', [
            'allOffers' => $response->allOffers,
            'userApplications' => $response->userApplications
        ]), $response->status);
    }
}