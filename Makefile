.PHONY: build up down restart logs shell composer artisan test init db-refresh

build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

restart: down up

logs:
	docker-compose logs -f

shell:
	docker-compose exec app bash

composer:
	docker-compose exec app composer $(cmd)

artisan:
	docker-compose exec app php artisan $(cmd)

test:
	docker-compose exec app php artisan test

init:
	docker-compose build
	docker-compose up -d

db-refresh:
	docker-compose exec app php artisan migrate:fresh --seed