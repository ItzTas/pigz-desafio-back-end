#!/bin/bash

cleanup() {
    echo "Stoping server"
    symfony server:stop
    exit 0
}

symfony server:stop >/dev/null 2>&1

php bin/console doctrine:database:create --if-not-exists >/dev/null 2>&1

mkdir -p migrations
php bin/console doctrine:migrations:diff --from-empty-schema >/dev/null 2>&1

php bin/console doctrine:migrations:migrate --no-interaction >/dev/null 2>&1

php bin/console doctrine:fixtures:load --append --no-interaction >/dev/null 2>&1

symfony server:start --port=8080 --allow-all-ip
