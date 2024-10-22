<?php
declare(strict_types=1);

use nrv\application\actions\AfficheListeSpectaclesAction;
use nrv\application\actions\ConnexionAction;
use nrv\application\actions\GetPanierByIdAction;
use nrv\application\actions\GetUserBilletsAction;
use nrv\application\actions\InscriptionAction;
use Slim\Exception\HttpNotFoundException;
use nrv\application\actions\HomeAction;
use nrv\application\actions\GetSoireesSpectacles;
use \nrv\application\actions\AfficheDetailSoireeAction;

return function (\Slim\App $app): \Slim\App {

    $app->get('/', HomeAction::class);

    $app->get('/soirees/{id}', AfficheDetailSoireeAction::class);

    
    $app->get('/spectacles/{id}/soirees[/]', GetSoireesSpectacles::class);
    $app->get('/spectacles', AfficheListeSpectaclesAction::class);

    $app->post('/inscription', [InscriptionAction::class, 'inscription']);

    $app->post('/connexion', ConnexionAction::class);

    $app->get('/utilisateur/{id}/billets', GetUserBilletsAction::class);

    $app->get('/utilisateur/{id}/paniers', GetPanierByIdAction::class);


    $app->get('/spectacles/{dateDeb}/{dateFin}', \nrv\application\actions\AfficheDateSpectacleAction::class);

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });    

    return $app;
};
