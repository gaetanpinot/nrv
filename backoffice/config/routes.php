<?php
declare(strict_types=1);

use nrv\back\application\actions\AfficherJaugeSpectacleAction;
use nrv\back\application\actions\AjouterSoireeAction;
use nrv\back\application\actions\AjouterSpectacleAction;
use Slim\Exception\HttpNotFoundException;
use nrv\back\application\actions\HomeAction;

return function (\Slim\App $app): \Slim\App {

    $app->get('/', HomeAction::class);

    $app->get('/jauge[/]', AfficherJaugeSpectacleAction::class);

    $app->post('/spectacles/ajouter[/]', AjouterSpectacleAction::class);

    $app->post('/soirees/ajouter[/]', AjouterSoireeAction::class);

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });    

    return $app;
};
