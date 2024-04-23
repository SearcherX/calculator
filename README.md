<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Базовый шаблон проекта обучения</h1>
    <br>
</p>

## Окружение

Требования к окружению:

* WSL / Linux
* docker 1.10.0+
* Make

### Переменные окружения

```dotenv
# Порт веб-сервера
APP_WEB_PORT=8077
```

## Установка с использованием docker compose

1. Скопировать **.env.dist** в **.env** и актуализировать все параметры
1. Выполнить скрипт установки проекта
> В среде Windows скрипт запускать при помощи Git bash
```sh
docker compose -p calculator down --remove-orphans && \
docker build --target=common-tools \
	-t localhost/calculator-common-tools:latest -f ./docker/Dockerfile . && \
docker build --target=fpm \
	--build-arg USER=1000 \
	--build-arg GROUP=1000 \
	-t localhost/calculator-php-fpm:latest -f ./docker/Dockerfile . && \
docker build --target=nginx \
	-t localhost/calculator-nginx:latest -f ./docker/Dockerfile . && \
docker compose -p calculator up -d && \
docker compose -p calculator run --rm php-fpm composer install --no-cache
```

### Служебное

- запуск контейнеров
    ```sh
    docker compose -p calculator up -d
    ```
- остановка контейнеров
    ```sh
    docker compose -p calculator down --remove-orphans
    ```
- перезапустить контейнеры
    ```sh
    docker compose -p calculator down --remove-orphans && docker compose -p calculator up -d
    ```
- логи контейнеров
    ```sh
    docker compose -p calculator logs -f
    ```
- статус контейнеров
    ```sh
    docker compose -p calculator ps
    ```
- установка php-зависимостей из регистра зависимостей composer.json
    ```sh
    docker compose -p calculator run --rm php-fpm composer install --no-cache
    ```
- установка php-зависимости
    ```sh
    docker compose -p calculator run --rm php-fpm composer require <имя_пакета>
    ```

## Установка с использованием утилиты Make

1. Скопировать **.env.dist** в **.env** и актуализировать все параметры
1. `make install` - установить проект

### Служебное

- `make install` - установка проекта
- `make up` - запуск контейнеров
- `make down` - остановка контейнеров
- `make restart` - перезапустить контейнеры
- `make logs` - логи контейнеров
- `make ps` - статус контейнеров
- `make composer-install` - установка php-зависимостей