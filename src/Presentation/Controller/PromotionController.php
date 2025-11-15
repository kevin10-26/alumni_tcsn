<?php declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Psr\Http\Message\ServerRequestInterface;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;

use Twig\Environment;

use Alumni\Application\UseCase\ManagePromotionModal\ManagePromotionModalUseCase;
use Alumni\Application\UseCase\ManagePromotionModal\ManagePromotionModalRequest;

use Alumni\Application\UseCase\SearchStudentPromotion\SearchStudentPromotionUseCase;
use Alumni\Application\UseCase\SearchStudentPromotion\SearchStudentPromotionRequest;

use Alumni\Application\UseCase\GetStudentPromotion\GetStudentPromotionUseCase;
use Alumni\Application\UseCase\GetStudentPromotion\GetStudentPromotionRequest;

use Alumni\Application\UseCase\CreatePromotion\CreatePromotionUseCase;
use Alumni\Application\UseCase\CreatePromotion\CreatePromotionRequest;

use Alumni\Application\UseCase\EditPromotion\EditPromotionUseCase;
use Alumni\Application\UseCase\EditPromotion\EditPromotionRequest;

use Alumni\Application\UseCase\RemovePromotion\RemovePromotionUseCase;
use Alumni\Application\UseCase\RemovePromotion\RemovePromotionRequest;

class PromotionController
{
    public function __construct(
        private readonly ManagePromotionModalUseCase $managePromotionModal,
        private readonly SearchStudentPromotionUseCase $searchStudentPromotion,
        private readonly GetStudentPromotionUseCase $getStudentPromotion,
        private readonly CreatePromotionUseCase $createPromotion,
        private readonly EditPromotionUseCase $editPromotion,
        private readonly RemovePromotionUseCase $removePromotion,
        private readonly Environment $twig
    ) {}

    public function manageModal(ServerRequestInterface $request): HtmlResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true);

        $requestDTO = new ManagePromotionModalRequest($user['userId'], intval($requestBody['promId']));
        $response = $this->managePromotionModal->execute($requestDTO);

        return new HtmlResponse($this->twig->render('./Components/Backoffice/ManagePromModal.twig', [
            'promotion' => $response->promotion,
            'attachedDelegates' => $response->attachedDelegates
        ]), $response->status);
    }

    public function searchStudent(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true);

        $requestDTO = new SearchStudentPromotionRequest($user['userId'], $requestBody['input']);
        $response = $this->searchStudentPromotion->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'usernames' => $response->usernames
        ], $response->status);
    }

    public function getStudent(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true);

        $requestDTO = new GetStudentPromotionRequest($user['userId'], $requestBody['input']);
        $response = $this->getStudentPromotion->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
        ], $response->status);
    }

    public function create(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;

        $requestBody = $request->getParsedBody();

        $students = explode(',', $requestBody['students']);
        $delegates = explode(',', $requestBody['delegates']);

        $requestDTO = new CreatePromotionRequest($user['userId'], $requestBody['name'], intval($requestBody['year']), $students, $delegates);
        $response = $this->createPromotion->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg
        ], $response->status);
    }

    public function edit(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;

        $requestBody = $request->getParsedBody();

        $students = explode(',', $requestBody['students']);
        $delegates = explode(',', $requestBody['delegates']);

        $requestDTO = new EditPromotionRequest($user['userId'], intval($requestBody['promId']), $requestBody['name'], intval($requestBody['year']), $students, $delegates);
        $response = $this->editPromotion->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg
        ], $response->status);
    }

    public function remove(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;
        
        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true);

        $requestDTO = new RemovePromotionRequest($user['userId'], intval($requestBody['promId']));
        $response = $this->removePromotion->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg
        ], $response->status);
    }
}