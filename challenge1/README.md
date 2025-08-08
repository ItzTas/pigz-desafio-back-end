# Challenge 1

## Instruções

Antes de iniciar a api execute esses comandos

```bash
composer install
rm migrations/*
php bin/console doctrine:migrations:diff --from-empty-schema
chmod 777 var/data_dev.db
```

Agora é só rodar

```bash
docker compose up
```
