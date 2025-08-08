#!/bin/env sh

until pg_isready -h database -U user -d db; do
    echo "Esperando o banco de dados..."
    sleep 2
done

php bin/console doctrine:database:create --if-not-exists

mkdir -p migrations
php bin/console doctrine:migrations:diff --from-empty-schema

php bin/console doctrine:migrations:migrate --no-interaction

php bin/console doctrine:fixtures:load --append --no-interaction
