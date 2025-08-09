#!/bin/bash

cleanup() {
    echo "Stoping server"
    symfony server:stop || true
    rm -f var/*.pid /tmp/*.pid /root/.symfony*/server.json 2>/dev/null || true
    exit 0
}

trap cleanup_and_exit SIGINT SIGTERM

symfony server:stop || true
rm -f var/*.pid /tmp/*.pid /root/.symfony*/server.json 2>/dev/null || true

symfony server:stop >/dev/null 2>&1

php bin/console doctrine:database:create --if-not-exists >/dev/null 2>&1

mkdir -p migrations
php bin/console doctrine:migrations:diff --from-empty-schema >/dev/null 2>&1

php bin/console doctrine:migrations:migrate --no-interaction >/dev/null 2>&1

php bin/console doctrine:fixtures:load --append --no-interaction >/dev/null 2>&1

symfony server:start --port=8080 --allow-all-ip
