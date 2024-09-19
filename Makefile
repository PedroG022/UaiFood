# Variables
DOCKER_COMPOSE=docker compose
SYMFONY_SERVER=docker compose exec php bin/console

# Default target: start the application
all: up

shell:
	$(DOCKER_COMPOSE) exec -it php bash

## Build the Docker images (run after changes in Dockerfile)
build:
	$(DOCKER_COMPOSE) build --no-cache

## Start the docker containers
up:
	$(DOCKER_COMPOSE) up -d

## Stop the docker containers
down:
	$(DOCKER_COMPOSE) down

## Stop and remove all containers, networks, volumes, and images
clean:
	$(DOCKER_COMPOSE) down --rmi all -v --remove-orphans

## View container logs
logs:
	$(DOCKER_COMPOSE) logs -f

## Run Symfony console commands
console:
	$(SYMFONY_SERVER)

## Clear Symfony cache
cache-clear:
	$(SYMFONY_SERVER) cache:clear

## Load initial fixtures to database
db-fixtures:
	$(SYMFONY_SERVER) doctrine:fixtures:load
