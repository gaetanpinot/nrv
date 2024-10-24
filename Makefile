phpdocker=nrv-api.nrv-1
webdocker = nrv-web-1
backdocker = nrv-backoffice.nrv-1
web-backdocker = nrv-web-back-1
buildProject:
	make install
	make buildJs
	make genereDb
install: 
	sudo docker compose up -d --build
	sudo docker exec -it $(phpdocker) composer install
	sudo docker exec -it $(backdocker) composer install
installNoSudo:
	docker compose up -d --build
	docker exec -it $(phpdocker) composer install
	docker exec -it $(backdocker) composer install

buildJs:
	sudo docker exec -it $(webdocker) npm  run build
	sudo docker exec -it $(web-backdocker) npm  run build

buildJsNoSudo:
	docker exec -it $(webdocker) npm  run build
	docker exec -it $(web-backdocker) npm  run build

watchSassNoSudo:
	docker exec -it $(webdocker) node-sass -w ./sass -o ./css
watchSass:
	sudo docker exec -it $(webdocker) node-sass -w ./sass -o ./css
watchSassBack:
	sudo docker exec -it $(web-backdocker) node-sass -w ./sass -o ./css

watchLogs:
	watch -n 2 tail app/var/logs

genereDb:
	sudo docker exec -it $(phpdocker) php src/infrastructure/genereDb.php
genereDbNoSudo:
	docker exec -it $(phpdocker) php src/infrastructure/genereDb.php
