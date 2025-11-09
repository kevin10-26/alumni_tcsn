<?php declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Psr\Http\Message\ServerRequestInterface;

use Laminas\Diactoros\Response\JsonResponse;

use Twig\Environment;

use Alumni\Application\UseCase\GetCompany\GetCompanyUseCase;
use Alumni\Application\UseCase\GetCompany\GetCompanyRequest;

use Alumni\Application\UseCase\SearchCompany\SearchCompanyUseCase;
use Alumni\Application\UseCase\SearchCompany\SearchCompanyRequest;

class CompanyController
{
    public function __construct(
        private readonly SearchCompanyUseCase $searchCompany,
        private readonly GetCompanyUseCase $getCompany,
        private readonly Environment $twig
    ) {}

    public function search(ServerRequestInterface $request): JsonResponse
    {
        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true) ?? [];

        $requestDTO = new SearchCompanyRequest($requestBody['input']);
        
        $response = $this->searchCompany->execute($requestDTO);

        return new JsonResponse([
            'data' => $response->companies,
        ], $response->status);
    }

    public function get(ServerRequestInterface $request): JsonResponse
    {
        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true) ?? [];

        $requestDTO = new GetCompanyRequest($requestBody['input']);
        
        $response = $this->getCompany->execute($requestDTO);

        return new JsonResponse([
            'data' => $response->company,
        ], $response->status);
    }
}