<?php


use nrv\back\application\actions\AfficherJaugeSpectacleAction;
use nrv\back\application\actions\HomeAction;




return [

    HomeAction::class=>DI\autowire(),
    AfficherJaugeSpectacleAction::class=>DI\autowire(),
];