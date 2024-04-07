up:
	cp api/.env.example api/.env
	composer install -d api
	docker-compose up -d --build --force-recreate --remove-orphans
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan optimize
	docker-compose exec app php artisan config:clear
	
down:
	docker-compose down

bash:
	docker exec -it challenge-truck-app-1 bash

op:
	docker-compose exec app php artisan optimize

fdb:
	docker-compose exec app php artisan migrate:fresh --seed

test:
	docker-compose exec app php artisan test --env=testing
	docker-compose exec app php artisan config:clear

cron:
	docker-compose exec app php artisan import:openfoodfacts