<?php declare(strict_types=1);

namespace Alumni\Presentation\Controller;

use Psr\Http\Message\ServerRequestInterface;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;

use Twig\Environment;

use Alumni\Application\UseCase\RegisterUser\RegisterUserUseCase;
use Alumni\Application\UseCase\RegisterUser\RegisterUserRequest;

use Alumni\Application\UseCase\AuthenticateUser\AuthenticateUserUseCase;
use Alumni\Application\UseCase\AuthenticateUser\AuthenticateUserRequest;

use Alumni\Application\UseCase\GetAdminDashboard\GetAdminDashboardUseCase;
use Alumni\Application\UseCase\GetAdminDashboard\GetAdminDashboardRequest;

use Alumni\Application\UseCase\UpdateUserProfile\UpdateUserProfileUseCase;
use Alumni\Application\UseCase\UpdateUserProfile\UpdateUserProfileRequest;

use Alumni\Application\UseCase\UpdateUserAvatar\UpdateUserAvatarUseCase;
use Alumni\Application\UseCase\UpdateUserAvatar\UpdateUserAvatarRequest;

use Alumni\Application\UseCase\DeactivateAccount\DeactivateAccountUseCase;
use Alumni\Application\UseCase\DeactivateAccount\DeactivateAccountRequest;

use Alumni\Application\UseCase\ReactivateAccount\ReactivateAccountUseCase;
use Alumni\Application\UseCase\ReactivateAccount\ReactivateAccountRequest;

class UserController
{
    public function __construct(
        private readonly RegisterUserUseCase $registerUser,
        private readonly AuthenticateUserUseCase $authenticateUser,
        private readonly GetAdminDashboardUseCase $getAdminDashboard,
        private readonly UpdateUserProfileUseCase $updateUserProfile,
        private readonly UpdateUserAvatarUseCase $updateUserAvatar,
        private readonly DeactivateAccountUseCase $deactivateAccount,
        private readonly ReactivateAccountUseCase $reactivateAccount,
        private readonly Environment $twig
    ) {}

    public function login(): HtmlResponse
    {
        return new HtmlResponse($this->twig->render('./Login.twig', []), 200);
    }

    public function identify(ServerRequestInterface $request): JsonResponse
    {
        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true) ?? [];

        $request = new RegisterUserRequest($requestBody['username'], $requestBody['emailAddress'], $requestBody['password']);
        $response = $this->registerUser->execute($request);

        return new JsonResponse([
            'status' => $response->status,
            'msg' => $response->msg
        ], $response->status);
    }

    public function authenticate(ServerRequestInterface $request): void
    {
        $requestBody = $request->getParsedBody();

        $request = new AuthenticateUserRequest($requestBody['email'], $requestBody['password']);
        $response = $this->authenticateUser->execute($request);

        if ($response->token)
        {
            header('Location:' . $_ENV['APP_URL'] . 'index');
            exit;
        } else {
            header('Location:' . $_ENV['APP_URL'] . 'login#bad-credentials');
            exit;
        }
    }

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

    public function updateUserProfile(ServerRequestInterface $request): JsonResponse
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

    public function updateUserAvatar(ServerRequestInterface $request): JsonResponse
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

    public function deactivate(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true) ?? [];

        $requestDTO = new DeactivateAccountRequest($user['userId'], intval($requestBody['daysDeactivated']));
        $response = $this->deactivateAccount->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status
        ], $response->status);
    }

    public function reactivate(ServerRequestInterface $request): JsonResponse
    {
        $user = $request->getAttribute('user')->token;

        $raw = (string) $request->getBody();
        $requestBody = json_decode($raw, true) ?? [];

        $requestDTO = new ReactivateAccountRequest($user['userId'], intval($requestBody['daysDeactivated']));
        $response = $this->reactivateAccount->execute($requestDTO);

        return new JsonResponse([
            'status' => $response->status
        ], $response->status);
    }
}