ROOT_DIR := $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))
OS := $(shell uname)

default: start

ash:
	docker exec -it slotegrator-php ash

db:
	docker exec -it slotegrator-postgres bash

start:
	@(echo "-> Starting application docker (local)")
	make restart
	@(./do.sh "composer install")
	@(echo "-> Done")

stop:
	@(echo "-> Stopping application docker (sync on mac)...")
	docker-compose stop
	@(echo "-> Done")

down:
	@(echo "-> Stopping & removing the application...")
	docker-compose down --remove-orphans
	@(echo "-> Done")

restart:
	docker-compose pull
	docker-compose up -d --force-recreate

fresh: refresh
refresh:
	@(echo "-> Refresh the application")
	@(./do.sh "php artisan migrate:fresh")
	@(./do.sh "php artisan db:seed")
	@(echo "-> Done")

migrate:
	@(echo "-> Running migrations...")
	@(./do.sh "php artisan migrate")
	@(echo "-> Done")

composer_install:
	@(echo "-> Installing composer dependencies...")
	@(./do.sh "composer install")
	@(echo "-> Done")

composer_update:
	@(echo "-> Updating composer dependencies...")
	@(./do.sh "composer update")
	@(echo "-> Done")

lint:
	@(echo "-> Running php lint...")
	@(./vendor/bin/phpcs --standard=ruleset.xml app -p)
	@(echo "-> Done")

test:
	@(echo "-> Running tests (dockered)...")
	@(./do.sh ./phpunit)
	@(echo "-> Done")

clean:
	@(echo "-> Cleaning caches (dockered)...")
	@(./do.sh "php artisan cache:clear")
	@(./do.sh "php artisan config:clear")
	@(./do.sh "php artisan view:clear")
	@(./do.sh "php artisan route:clear")
	@(./do.sh "php artisan debugbar:clear")
	@(echo "-> Done")

ide:
	@(echo "-> IDE helper: make `_ide_helper.php`, write models properties...")
	php artisan ide-helper:models -W -R
	@(echo "-> Done")

ide_full:
	@(echo "-> IDE helper: generating all smelly things...")
	php artisan ide-helper:generate
	php artisan ide-helper:meta
	php artisan ide-helper:models -W -R
	@(echo "-> Done")
