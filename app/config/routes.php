<?php
declare(strict_types=1);

use nrv\application\actions\AfficheListeSpectaclesAction;
use nrv\application\actions\AjouterBilletDansPanierAction;
use nrv\application\actions\ConnexionAction;
use nrv\application\actions\GetPanierByIdAction;
use nrv\application\actions\GetUserBilletsAction;
use nrv\application\actions\InscriptionAction;
use Slim\Exception\HttpNotFoundException;
use nrv\application\actions\HomeAction;
use nrv\application\actions\GetSoireesSpectaclesAction;
use \nrv\application\actions\AfficheDetailSoireeAction;
use \nrv\application\actions\GetLieuxAction;
use \nrv\application\actions\GetThemesAction;

return function (\Slim\App $app): \Slim\App {

    $app->get('/', HomeAction::class);

    $app->get('/soirees/{id}[/]', AfficheDetailSoireeAction::class);

    $app->get('/spectacles/{id}/soirees[/]', GetSoireesSpectaclesAction::class);

    $app->get('/spectacles[/]', AfficheListeSpectaclesAction::class);

    $app->post('/inscription[/]', InscriptionAction::class);

    $app->post('/utilisateur[/]', ConnexionAction::class);

    $app->get('/utilisateurs/{id}/billets[/]', GetUserBilletsAction::class)->add(new \nrv\application\middlewares\JwtMiddleware());

    $app->get('/utilisateurs/{id}/panier[/]', GetPanierByIdAction::class)->add(new \nrv\application\middlewares\JwtMiddleware());

    $app->post('/panier/billet', AjouterBilletDansPanierAction::class)->add(new \nrv\application\middlewares\JwtMiddleware());

    $app->get('/lieux[/]', GetLieuxAction::class);

    $app->get('/themes[/]', GetThemesAction::class);

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });    

    return $app;
};
