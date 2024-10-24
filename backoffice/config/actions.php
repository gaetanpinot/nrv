<?php


use nrv\back\application\actions\AfficherJaugeSpectacleAction;
use nrv\back\application\actions\AjouterModifierLieuAction;
use nrv\back\application\actions\AjouterSpectacleAction;
use nrv\back\application\actions\HomeAction;




return [

    HomeAction::class=>DI\autowire(),
    AfficherJaugeSpectacleAction::class=>DI\autowire(),
    AjouterSpectacleAction::class=>DI\autowire(),
    AjouterModifierLieuAction::class=>DI\autowire(),
    \nrv\back\application\actions\SupprimerLieuAction::class=>DI\autowire(),
    \nrv\back\application\actions\AjouterSoireeAction::class=>DI\autowire(),
];
