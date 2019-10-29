.PHONY: start
start: stop composer up db

.PHONY: ci
ci: stop composer up db test
		docker-compose exec laravel cp .env.example .env

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