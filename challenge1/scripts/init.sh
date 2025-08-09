#!/bin/bash

php bin/console doctrine:database:create --if-not-exists

mkdir -p migrations
php bin/console doctrine:migrations:diff --from-empty-schema

php bin/console doctrine:migrations:migrate --no-interaction

php bin/console doctrine:fixtures:load --append --no-interaction

symfony server:start --port=8080 --allow-all-ip
