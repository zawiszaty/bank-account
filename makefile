.PHONY: start
start: env stop composer up db

.PHONY: ci
ci: env stop composer up db test

.PHONY: env
env:
		cp laravel-microservice/.env.example laravel-microservice/.env

.PHONY: stop
stop: ## stop environment
		docker-compose stop

.PHONY: composer
composer: ## spin up environment
		docker-compose run monolith php composer.phar install
		docker-compose run laravel php composer.phar install

.PHONY: up
up: ## up docker
		docker-compose up -d

.PHONY: db
db: ## up db
		-docker-compose exec laravel php artisan migrate:install
		docker-compose exec laravel php artisan migrate

.PHONY: test
test:
		docker-compose exec laravel ./vendor/bin/phpunit
		docker-compose exec monolith ./vendor/bin/phpunit

.PHONY: monolith
monolith: ## login into monolith container
		docker-compose exec monolith /bin/sh