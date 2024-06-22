# User Id
UNAME = $(shell uname)
# Stack name (default: current dir)
STACK_NAME = $(notdir $(CURDIR))

ifeq ($(UNAME), Linux)
    UID = $(shell id -u)
else
    UID = 1000
endif

INTERACTIVE:=$(shell [ -t 0 ] && echo 1)

ifdef INTERACTIVE
# is a terminal
	TTY_DOCKER=-it
	TTY_COMPOSE=
else
# bash job
	TTY_DOCKER=
	TTY_COMPOSE=-T
endif

# Executables (local)
COMPOSE = docker compose

# Misc
.DEFAULT_GOAL = help
.PHONY        = help build up start down logs sh composer vendor sf cc symfony

help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

##- Docker
build: ## Builds the Docker images
	@$(COMPOSE) build --pull

build-no-cache: ## Builds the Docker images (no cache)
	@$(COMPOSE) build --pull --no-cache

up: ## Start the docker hub in detached mode (no logs)
	@$(COMPOSE) up --detach
	symfony serve -d

start: up ## Build and start the containers

down: ## Stop the docker hub
	@$(COMPOSE) down --remove-orphans

logs: ## Show live logs
	@$(COMPOSE) logs --tail=0 --follow

watch: ## watch to rebuild front assets
	symfony console tailwind:build --watch

fixtures: ## load fixtures
	symfony console d:d:d --force
	symfony console d:d:c
	symfony console d:m:m --no-interaction
	symfony console d:f:l --no-interaction