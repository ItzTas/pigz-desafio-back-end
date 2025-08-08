# Challenge 1

## Instruções

Antes de iniciar a api execute esses comandos dentro do diretorio challenge1

```bash
composer install
mkdir migrations
php bin/console doctrine:migrations:diff --from-empty-schema
php bin/console doctrine:migrations:migrate
chmod 777 var/data_dev.db
```

Agora é só rodar

```bash
docker compose up
```
