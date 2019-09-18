.RECIPEPREFIX +=
.DEFAULT_GOAL := help

.NOCOLOR=\e[0m
.YELLOWCOLOR=\e[43m
.REDCOLOR=\e[101m

help:
  @echo "\033[33mUsage:\033[0m\n  make [target] [arg=\"val\"...]\n\n\033[33mTargets:\033[0m"
  @grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-15s\033[0m %s\n", $$1, $$2}'

destroy-stocky: ## Destroy Magento docker containers
  @docker-compose down
  @docker volume rm project-20_dbdata
  @docker volume rm project-20_esdata

offloader: ## Run Development environment
  @docker-compose -f docker-compose.offloader.yaml up -d

dev: ## Run Development environment
  @docker-compose up nginx_formula fpm

bash: ## Run Bash in CLI container
  @docker-compose run --rm cli bash

bash-root: ## Run Bash as root in CLI container
  @docker-compose run --rm cli root bash

install: ## Update composer
  @composer install
  @docker-compose run --rm cli composer install

git-flush:
  @echo "${.YELLOWCOLOR}Flushing local git branches...${.NOCOLOR}"
  @git remote prune origin
  @git branch -vv | grep 'origin/.*: gone]' | awk '{print $1}' | xargs git branch -d