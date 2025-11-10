<?php

declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

use Alumni\Presentation\Middleware\TwigContextMiddleware;

use Alumni\Infrastructure\Repository\DB\Mapper\UserMapper;
use Alumni\Infrastructure\Repository\DB\Mapper\ChannelMapper;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Infrastructure\Repository\DB\UserRepository;

use Alumni\Domain\Repository\DB\EventRepositoryInterface;
use Alumni\Infrastructure\Repository\DB\EventRepository;

use Alumni\Domain\Repository\DB\RefreshTokenRepositoryInterface;
use Alumni\Infrastructure\Repository\DB\RefreshTokenRepository;

use Alumni\Domain\Service\AuthServiceInterface;
use Alumni\Infrastructure\Service\AuthService;

use Alumni\Domain\Service\JWTServiceInterface;
use Alumni\Infrastructure\Service\JWTService;

use Alumni\Domain\Service\ChannelServiceInterface;
use Alumni\Infrastructure\Service\ChannelService;

use Alumni\Domain\Service\UserServiceInterface;
use Alumni\Infrastructure\Service\UserService;

use Alumni\Domain\Service\FileServiceInterface;
use Alumni\Infrastructure\Service\FileService;

use Alumni\Domain\Service\ReportsServiceInterface;
use Alumni\Infrastructure\Service\ReportsService;

use Alumni\Infrastructure\Repository\DB\ChannelRepository;
use Alumni\Domain\Repository\DB\ChannelRepositoryInterface;

use Alumni\Infrastructure\Repository\DB\ChannelMembershipRepository;
use Alumni\Domain\Repository\DB\ChannelMembershipRepositoryInterface;

use Alumni\Infrastructure\Repository\DB\ChannelPostRepository;
use Alumni\Domain\Repository\DB\ChannelPostRepositoryInterface;

use Alumni\Infrastructure\Repository\DB\AttachmentsRepository;
use Alumni\Domain\Repository\DB\AttachmentsRepositoryInterface;

use Alumni\Domain\Repository\DB\JobOfferRepositoryInterface;
use Alumni\Infrastructure\Repository\DB\JobOfferRepository;

use Alumni\Domain\Repository\DB\CompanyRepositoryInterface;
use Alumni\Infrastructure\Repository\DB\CompanyRepository;

use Alumni\Domain\Repository\DB\AnnouncesRepositoryInterface;
use Alumni\Infrastructure\Repository\DB\AnnouncesRepository;

use Alumni\Domain\Repository\File\ChannelFileRepositoryInterface;
use Alumni\Infrastructure\Repository\File\ChannelFileRepository;

use Alumni\Domain\Repository\File\PostChannelFileRepositoryInterface;
use Alumni\Infrastructure\Repository\File\PostChannelFileRepository;

use Alumni\Domain\Repository\File\UserFileRepositoryInterface;
use Alumni\Infrastructure\Repository\File\UserFileRepository;

use Alumni\Domain\Repository\DB\ReportsRepositoryInterface;
use Alumni\Infrastructure\Repository\DB\ReportsRepository;


// use Alumni\Infrastructure\Repository\DB\UserMapper;

use function DI\autowire;

return [

    // Twig bindings
    FilesystemLoader::class => function () {
        return new FilesystemLoader(__DIR__ . '/../src/Presentation/Template');
    },

    Environment::class => function (FilesystemLoader $loader) {
        $twig = new Environment($loader, [
            'cache' => __DIR__ . '/../../var/cache/twig',
            'auto_reload' => true,
            'debug' => $_ENV['APP_ENV'] === 'dev'
        ]);

        // Ajout de la fonction dump simplifiée
        $twig->addFunction(new \Twig\TwigFunction('dump', function ($var) {
            return '<pre>' . htmlspecialchars(print_r($var, true)) . '</pre>';
        }));

        return $twig;
    },
    TwigContextMiddleware::class => autowire(TwigContextMiddleware::class),

    // Doctrine bindings
    DriverManager::class => function () {
        $dbParams = [
            'driver' => 'pdo_mysql',
            'host' => $_ENV['DB_HOST'] ?? 'localhost',
            'port' => (int) ($_ENV['DB_PORT'] ?? 3306),
            'dbname' => $_ENV['DB_NAME'] ?? 'alumni_tcsn',
            'user' => $_ENV['DB_USER'] ?? 'kevin',
            'password' => $_ENV['DB_PASSWORD'] ?? '',
            'charset' => 'utf8mb4'
        ];

        return DriverManager::getConnection($dbParams);
    },

    // Configuration de l'EntityManager Doctrine ORM
    EntityManager::class => function (\Psr\Container\ContainerInterface $c) {
        $paths = [__DIR__ . '/../src/Infrastructure/Entity'];
        $isDevMode = $_ENV['APP_ENV'] === 'dev';

        $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);

        return new EntityManager($c->get(DriverManager::class), $config);
    },

    EntityManagerInterface::class => function (\Psr\Container\ContainerInterface $c) {
        return $c->get(EntityManager::class);
    },

    // Infrastructure bindings
    UserRepositoryInterface::class => autowire(UserRepository::class),
    EventRepositoryInterface::class => autowire(EventRepository::class),
    RefreshTokenRepositoryInterface::class => autowire(RefreshTokenRepository::class),
    EventRepositoryInterface::class => autowire(EventRepository::class),

    ChannelRepositoryInterface::class => DI\autowire(ChannelRepository::class),
    ChannelMembershipRepositoryInterface::class => DI\autowire(ChannelMembershipRepository::class),
    ChannelPostRepositoryInterface::class => DI\autowire(ChannelPostRepository::class),
    AttachmentsRepositoryInterface::class => DI\autowire(AttachmentsRepository::class),
    JobOfferRepositoryInterface::class => DI\autowire(JobOfferRepository::class),
    CompanyRepositoryInterface::class => DI\autowire(CompanyRepository::class),
    AnnouncesRepositoryInterface::class => DI\autowire(AnnouncesRepository::class),
    ReportsRepositoryInterface::class => DI\autowire(ReportsRepository::class),
    ChannelFileRepositoryInterface::class => DI\autowire(ChannelFileRepository::class),
    PostChannelFileRepositoryInterface::class => DI\autowire(PostChannelFileRepository::class),
    UserFileRepositoryInterface::class => DI\autowire(UserFileRepository::class),


    AuthServiceInterface::class => autowire(AuthService::class),
    JWTService::class => function () {
        return new JWTService(
            pathToPrivateKey: $_ENV['JWT_PRIVATE_KEY_PATH'] ?? __DIR__ . '/../config/jwt/private.pem',
            privKeyPassPhrase: $_ENV['JWT_PRIVATE_KEY_PASSPHRASE'] ?? '',
            pathToPublicKey: $_ENV['JWT_PUBLIC_KEY_PATH'] ?? __DIR__ . '/../config/jwt/public.pem'
        );
    },
    JWTServiceInterface::class => function (\Psr\Container\ContainerInterface $c) {
        return $c->get(JWTService::class);
    },
    ChannelServiceInterface::class => DI\autowire(ChannelService::class),
    FileServiceInterface::class => DI\autowire(FileService::class),
    ReportsServiceInterface::class => DI\autowire(ReportsService::class),
    UserServiceInterface::class => DI\autowire(UserService::class)
];