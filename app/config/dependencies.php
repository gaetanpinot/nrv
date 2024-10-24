<?php

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use nrv\back\core\domain\entities\Lieu\Lieu;
use nrv\core\repositoryInterfaces\SoireeRepositoryInterface;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;
use nrv\core\service\spectacle\SpectacleService;
use nrv\core\service\spectacle\SpectacleServiceInterface;
use nrv\infrastructure\Repositories\SoireeRepository;
use nrv\infrastructure\Repositories\SpectacleRepository;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use nrv\middlewares\CorsMiddleware;
use nrv\infrastructure\Repositories\LieuRepository;
use nrv\core\repositoryInterfaces\LieuRepositoryInterface;
use nrv\core\service\lieu\LieuServiceInterface;
use nrv\core\service\lieu\LieuService;

return [

    //Repository interface
    SpectacleRepositoryInterface::class => DI\autowire(SpectacleRepository::class),
    SoireeRepositoryInterface::class => DI\autowire(SoireeRepository::class),
    LieuRepositoryInterface::class => DI\autowire(LieuRepository::class),
    //Services
    SpectacleServiceInterface::class => DI\create(SpectacleService::class)->constructor(DI\get(ContainerInterface::class)),
    LieuServiceInterface::class => DI\create(LieuService::class)->constructor(DI\get(ContainerInterface::class)),
    //PDO
    'pdo.commun' => function(ContainerInterface $c){
        $config= parse_ini_file($c->get('db.config'));
        return new PDO($config['driver'].':host='.$config['host'].';port='.$config['port'].';dbname='.$config['dbname'].';user='.$config['user'].';password='.$config['password']);
    },

    //auth
    
    StreamHandler::class => DI\create(StreamHandler::class)
        ->constructor(DI\get('logs.dir'), Level::Debug)
        ->method('setFormatter', DI\get(LineFormatter::class)),

    
    LineFormatter::class => function() {
        $dateFormat = "d/m/Y H:i"; // Format de la date que tu veux
        $output = "[%datetime%] %channel%.%level_name%: %message% %context%\n"; // Format des logs
        return new LineFormatter($output, $dateFormat);
    },
    LoggerInterface::class => DI\create(Logger::class)->constructor('sae-5-Logger', [DI\get(StreamHandler::class)]),

    CorsMiddleware::class => DI\autowire(),




];
