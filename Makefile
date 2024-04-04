up:
	docker-compose up -d --build --force-recreate --remove-orphans
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan cache:clear
	
down:
	docker-compose down

bash:
	docker exec -it challenge-truck-app-1 bash

op:
	docker-compose exec app php artisan optimize

fdb:
	docker-compose exec app php artisan migrate:fresh --seed