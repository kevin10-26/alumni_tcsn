<?php declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Psr\Http\Message\ServerRequestInterface;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;

use Twig\Environment;

use Alumni\Application\UseCase\GetAdminDashboard\GetAdminDashboardUseCase;
use Alumni\Application\UseCase\GetAdminDashboard\GetAdminDashboardRequest;

use Alumni\Application\UseCase\UpdateUserProfile\UpdateUserProfileUseCase;
use Alumni\Application\UseCase\UpdateUserProfile\UpdateUserProfileRequest;

use Alumni\Application\UseCase\UpdateUserAvatar\UpdateUserAvatarUseCase;
use Alumni\Application\UseCase\UpdateUserAvatar\UpdateUserAvatarRequest;

class UserController
{
    public function __construct(
        private readonly GetAdminDashboardUseCase $getAdminDashboard,
        private readonly UpdateUserProfileUseCase $updateUserProfile,
        private readonly UpdateUserAvatarUseCase $updateUserAvatar,
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

    public function updateUserProfile(ServerRequestInterface $request)
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true) ?? [];

        $requestDTO = new UpdateUserProfileRequest($user['userId'], $requestBody['field'], $requestBody['value']);
        $response = $this->updateUserProfile->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg,
            'newValue' => $response->updatedValue
        ], $response->status);
    }

    public function updateUserAvatar(ServerRequestInterface $request)
    {
        $user = $request->getAttribute('user')->token;

        $requestDTO = new UpdateUserAvatarRequest($user['userId'], $request->getUploadedFiles()['avatar']);
        $response = $this->updateUserAvatar->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg,
            'avatarPath' => $response->updatedAvatarPath
        ], $response->status);
    }
}