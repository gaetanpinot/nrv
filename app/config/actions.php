<?php

use nrv\application\actions\AfficheDetailSoireeAction;
use nrv\application\actions\AfficheListeSpectaclesAction;
use nrv\application\actions\HomeAction;




return [

    HomeAction::class=>DI\autowire(),
    AfficheListeSpectaclesAction::class=>DI\autowire(),
    AfficheDetailSoireeAction::class=>DI\autowire(),
];
