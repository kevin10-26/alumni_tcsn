<?php declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Psr\Http\Message\ServerRequestInterface;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;

use Twig\Environment;

use Alumni\Application\UseCase\ShowBackoffice\ShowBackofficeRequest;
use Alumni\Application\UseCase\ShowBackoffice\ShowBackofficeUseCase;

use Alumni\Application\UseCase\ShowReportDetails\ShowReportDetailsRequest;
use Alumni\Application\UseCase\ShowReportDetails\ShowReportDetailsUseCase;

use Alumni\Application\UseCase\WithdrawReportedContent\WithdrawReportedContentRequest;
use Alumni\Application\UseCase\WithdrawReportedContent\WithdrawReportedContentUseCase;

use Alumni\Application\UseCase\DisclaimReportedContent\DisclaimReportedContentRequest;
use Alumni\Application\UseCase\DisclaimReportedContent\DisclaimReportedContentUseCase;

use Alumni\Application\UseCase\RefreshBackofficeTab\RefreshBackofficeTabRequest;
use Alumni\Application\UseCase\RefreshBackofficeTab\RefreshBackofficeTabUseCase;

class BackofficeController
{
    public function __construct(
        private readonly ShowBackofficeUseCase $showBackoffice,
        private readonly ShowReportDetailsUseCase $showReportDetails,
        private readonly WithdrawReportedContentUseCase $withdrawReportedContent,
        private readonly DisclaimReportedContentUseCase $disclaimReportedContent,
        private readonly RefreshBackofficeTabUseCase $refreshBackofficeTab,
        private readonly Environment $twig
    ) {}

    public function show(ServerRequestInterface $request): HtmlResponse
    {
        $user = $request->getAttribute('user')->token;

        $requestDTO = new ShowBackofficeRequest($user['userId']);
        $response = $this->showBackoffice->execute($requestDTO);

        return new HtmlResponse($this->twig->render('TemporaryBackoffice.twig', [
            'users' => $response->users,
            'proms' => $response->promotions,
            'registrationPool' => $response->registrationPool,
            'reports' => $response->reports,
            'announces' => $response->announces,
            'channels' => $response->channels,
            'jobOffers' => $response->jobOffers
        ]), $response->status);
    }

    public function getReportModal(ServerRequestInterface $request): HtmlResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true);

        $requestDTO = new ShowReportDetailsRequest($user['userId'], intval($requestBody['reportId']));
        $response = $this->showReportDetails->execute($requestDTO);

        return new HtmlResponse($this->twig->render('./Components/Backoffice/ReportModal.twig', [
            'report' => $response->report
        ]), $response->status);
    }

    public function deleteReportedContent(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true);

        $requestDTO = new WithdrawReportedContentRequest($user['userId'], intval($requestBody['reportId']), $requestBody['reportType'], $requestBody['reportReason'], 'withdraw');
        $response = $this->withdrawReportedContent->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg
        ], $response->status);
    }

    public function disclaimReportedContent(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true);

        $requestDTO = new DisclaimReportedContentRequest($user['userId'], intval($requestBody['reportId']), $requestBody['reportType'], $requestBody['reportReason'], 'disclaim');
        $response = $this->disclaimReportedContent->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg
        ], $response->status);
    }

    public function showUserReportModal(ServerRequestInterface $request): HtmlResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true);

        return new HtmlResponse($this->twig->render("./Components/Backoffice/UserReportModal.twig", [
            'id' => $requestBody['userId']
        ]), 200);
    }

    public function refresh(ServerRequestInterface $request): HtmlResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true);

        $requestDTO = new RefreshBackofficeTabRequest($user['userId'], $requestBody['contentType']);
        $response = $this->refreshBackofficeTab->execute($requestDTO);

        return new HtmlResponse($this->twig->render("./Components/Backoffice/$response->templateName.twig", [
            'status' => $response->status,
            'content' => $response->content
        ]), $response->status);
    }
}