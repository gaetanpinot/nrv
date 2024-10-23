<?php
declare(strict_types=1);

use nrv\application\actions\AfficherJaugeSpectacleAction;
use Slim\Exception\HttpNotFoundException;
use nrv\application\actions\HomeAction;

return function (\Slim\App $app): \Slim\App {

    $app->get('/', HomeAction::class);

    $app->get('/jauge[/]', AfficherJaugeSpectacleAction::class);



    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });    

    return $app;
};
