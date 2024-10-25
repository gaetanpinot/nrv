#!/bin/bash
phpdocker=nrv-api.nrv-1
webdocker=nrv-web-1
backdocker=nrv-backoffice.nrv-1
webbackdocker=nrv-web-back-1
docker compose up -d --build
docker exec -it $phpdocker composer install
docker exec -it $backdocker composer install
docker exec -it $webdocker npm  install
docker exec -it $webbackdocker npm  install
docker exec -it $webdocker npm  run build
docker exec -it $webbackdocker npm  run build
docker exec -it $webdocker node-sass  ./sass -o ./css
docker exec -it $webbackdocker node-sass ./sass -o ./css
docker exec -it $phpdocker php src/infrastructure/genereDb.php
