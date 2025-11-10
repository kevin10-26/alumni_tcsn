<?php declare(strict_types=1);

namespace Alumni\Presentation\Middleware;

use Twig\Environment;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;

use Alumni\Domain\Repository\DB\ChannelMembershipRepositoryInterface;

final class TwigContextMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly Environment $twig,
        private readonly ChannelMembershipRepositoryInterface $channelMembershipRepository
    ) {}

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        $user = $request->getAttribute('user');
        if (!is_null($user))
        {
            $userCurrentChannels = $this->channelMembershipRepository->getChannelsForUser($user->token['userId']);
            $this->twig->addGlobal('global_user_channels', $userCurrentChannels);
            $this->twig->addGlobal('global_logged_user', [
                'id' => $user->token['userId'],
                'role' => $user->token['role']
            ]);
        }

        return $handler->handle($request);
    }
}