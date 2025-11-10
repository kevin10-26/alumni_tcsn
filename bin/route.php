<?php

declare(strict_types=1);

use Alumni\Presentation\Controller\HomeController;
use Alumni\Presentation\Controller\UserController;
use Alumni\Presentation\Controller\AuthController;
use Alumni\Presentation\Controller\CompanyController;
use Alumni\Presentation\Controller\ChannelController;
use Alumni\Presentation\Controller\ChannelPostController;
use Alumni\Presentation\Controller\AnnouncesController;
use Alumni\Presentation\Controller\JobsController;
use Alumni\Presentation\Controller\ReportsController;

return [
    ['method' => 'GET', 'path' => '/', 'handler' => [HomeController::class, 'index']],

    ['method' => 'GET', 'path' => '/dashboard', 'handler' => [UserController::class, 'dashboard']],

    ['method' => 'POST', 'path' => '/dashboard/user/update', 'handler' => [UserController::class, 'updateUserProfile']],

    ['method' => 'POST', 'path' => '/dashboard/user/updateAvatar', 'handler' => [UserController::class, 'updateUserAvatar']],

    ['method' => 'POST', 'path' => '/auth/refresh', 'handler' => [AuthController::class, 'refreshToken']],

    ['method' => 'POST', 'path' => '/companies/search', 'handler' => [CompanyController::class, 'search']],

    ['method' => 'POST', 'path' => '/companies/get', 'handler' => [CompanyController::class, 'get']],

    ['method' => 'GET', 'path' => '/channels/list', 'handler' => [ChannelController::class, 'list']],

    ['method' => 'POST', 'path' => '/channels/actions/join', 'handler' => [ChannelController::class, 'join']],

    ['method' => 'POST', 'path' => '/channels/update', 'handler' => [ChannelController::class, 'updateChannelData']],

    ['method' => 'POST', 'path' => '/channels/update-thumbnail', 'handler' => [ChannelController::class, 'updateChannelThumbnail']],

    ['method' => 'POST', 'path' => '/channels/actions/quit', 'handler' => [ChannelController::class, 'quit']],

    ['method' => 'POST', 'path' => '/channels/actions/remove', 'handler' => [ChannelController::class, 'remove']],

    ['method' => 'POST', 'path' => '/channels/post/uploadFile/attachment', 'handler' => [ChannelPostController::class, 'addAttachment']],

    ['method' => 'POST', 'path' => '/channels/post/uploadFile/picture', 'handler' => [ChannelPostController::class, 'addPicture']],

    ['method' => 'POST', 'path' => '/channels/post/send', 'handler' => [ChannelPostController::class, 'send']],

    ['method' => 'POST', 'path' => '/channels/post/update/{postId}', 'handler' => [ChannelPostController::class, 'update']],

    ['method' => 'POST', 'path' => '/channels/post/remove', 'handler' => [ChannelPostController::class, 'remove']],

    ['method' => 'POST', 'path' => '/channels/post/refresh', 'handler' => [ChannelPostController::class, 'getAll']],

    ['method' => 'GET', 'path' => '/channels/{channelId}', 'handler' => [ChannelController::class, 'get']],

    ['method' => 'GET', 'path' => '/announces/list', 'handler' => [AnnouncesController::class, 'list']],

    ['method' => 'GET', 'path' => '/jobs/offers/list', 'handler' => [JobsController::class, 'list']],

    ['method' => 'POST', 'path' => '/report/create', 'handler' => [ReportsController::class, 'create']]
];