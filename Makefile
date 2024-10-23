phpdocker=nrv-api.nrv-1
webdocker = nrv-web-1
install: 
	sudo docker compose up -d
	sudo docker exec -it $(phpdocker) composer install
watchSassNoSudo:
	docker exec -it $(webdocker) node-sass -w ./sass -o ./css
watchSass:
	sudo docker exec -it $(webdocker) node-sass -w ./sass -o ./css
installNoSudo:
	docker compose up -d
	docker exec -it $(phpdocker) composer install
watchLogs:
	watch -n 2 tail app/var/logs
genereDb:
	sudo docker exec -it $(phpdocker) php src/infrastructure/genereDb.php
genereDbNoSudo:
	docker exec -it $(phpdocker) php src/infrastructure/genereDb.php
