phpdocker=nrv-api.nrv-1
install: 
	sudo docker compose up -d
	sudo docker exec -it $(phpdocker) composer install
installNoSudo:
	docker compose up -d
	docker exec -it $(phpdocker) composer install
watchLogs:
	watch -n 2 tail app/var/logs
genereDb:
	sudo docker exec -it $(phpdocker) php src/infrastructure/genereDb.php
genereDbNoSudo:
	docker exec -it $(phpdocker) php src/infrastructure/genereDb.php
