<?php declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Psr\Http\Message\ServerRequestInterface;

#use Laminas\Diactoros\Response\HtmlResponse;

use Alumni\Application\UseCase\CreateReport\CreateReportUseCase;
use Alumni\Application\UseCase\CreateReport\CreateReportRequest;

class ReportsController
{
    public function __construct(
        private readonly CreateReportUseCase $createReport
    ) {}

    public function create(ServerRequestInterface $request): void
    {
        $user = $request->getAttribute('user')->token;

        $raw = $request->getParsedBody();

        $requestDTO = new CreateReportRequest(
            userId: $user['userId'],
            entityId: intval($raw['entityId']),
            reportType: $raw['report-type'],
            topic: is_null($raw['report-topic']) ? $raw['report-topic-other'] : $raw['report-topic'],
            description: $raw['report-description'],
            attachments: $request->getUploadedFiles()['report-attachments']
        );

        $response = $this->createReport->execute($requestDTO);
        
        header("Location: /dashboard#reports-$response->status");
        exit;
    }
}