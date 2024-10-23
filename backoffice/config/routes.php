<?php
declare(strict_types=1);

use nrv\back\application\actions\AfficherJaugeSpectacleAction;
use nrv\back\application\actions\AfficheListeSpectaclesAction;
use nrv\back\application\actions\ConnexionAction;
use nrv\back\application\actions\GetPanierByIdAction;
use nrv\back\application\actions\GetUserBilletsAction;
use nrv\back\application\actions\InscriptionAction;
use Slim\Exception\HttpNotFoundException;
use nrv\back\application\actions\HomeAction;
use nrv\back\application\actions\GetSoireesSpectaclesAction;
use \nrv\back\application\actions\AfficheDetailSoireeAction;

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
