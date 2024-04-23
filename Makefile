include .env

install:
	@$(MAKE) -s down
	@$(MAKE) -s docker-build
	@$(MAKE) -s up
	@$(MAKE) -s composer-install

up:
	@docker compose -p calculator up -d

down:
	@docker compose -p calculator down --remove-orphans

ps:
	@docker compose -p calculator ps

restart: down up

logs:
	@docker compose -p calculator logs -f

docker-build: \
	docker-build-php-fpm \
	docker-build-nginx \
	docker-build-common-tools

docker-build-common-tools:
	@docker build --target=common-tools \
	-t localhost/calculator-common-tools:latest -f ./docker/Dockerfile .

docker-build-php-fpm:
	@docker build --target=fpm \
	--build-arg USER=1000 \
	--build-arg GROUP=1000 \
	-t localhost/calculator-php-fpm:latest -f ./docker/Dockerfile .

docker-build-nginx:
	@docker build --target=nginx \
	-t localhost/calculator-nginx:latest -f ./docker/Dockerfile .

composer-install:
	@docker compose -p calculator run --rm php-fpm composer install --no-cache