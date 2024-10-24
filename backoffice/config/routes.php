<?php
declare(strict_types=1);

use nrv\back\application\actions\AfficherJaugeSpectacleAction;
use nrv\back\application\actions\AjouterModifierLieuAction;
use nrv\back\application\actions\AjouterSoireeAction;
use nrv\back\application\actions\AjouterSpectacleAction;
use nrv\back\application\actions\SupprimerLieuAction;
use Slim\Exception\HttpNotFoundException;
use nrv\back\application\actions\HomeAction;

return function (\Slim\App $app): \Slim\App {

    $app->get('/', HomeAction::class);

    $app->get('/jauge[/]', AfficherJaugeSpectacleAction::class);

    $app->post('/spectacles[/]', AjouterSpectacleAction::class);

    $app->post('/soirees[/]', AjouterSoireeAction::class);

    $app->delete('/lieu[/]', SupprimerLieuAction::class);

    $app->put('/lieu[/]', AjouterModifierLieuAction::class);

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });    

    return $app;
};
