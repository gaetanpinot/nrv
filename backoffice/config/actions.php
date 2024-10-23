<?php


use nrv\application\actions\AfficherJaugeSpectacleAction;
use nrv\application\actions\HomeAction;




return [

    HomeAction::class=>DI\autowire(),
    AfficherJaugeSpectacleAction::class=>DI\autowire(),
];
