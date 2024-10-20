<?php

return [
    'token.temps.validite'=> 6060, // temps de validité du token jwt en seconde
    'token.emmeteur'=> "", //url de l'emmeteur du token
    'token.audience'=> "", //url de l'audience du token
    'token.key.path' => __DIR__ . '/../../sae-5.env', //path du fichier .env contenant le JWT secret key
    'token.jwt.algo' => 'HS512', //algo de jwt
];
