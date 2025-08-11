# Challenge 1

## Instruções

Pra iniciar o projeto apenas rode

```bash
docker compose up
```

## Endpoints

todas as rotas possuem o prefixo /api

Para fins de teste criei um superuser com todas as permissões e com as seguintes informações:

email = 'superuser@email';
name = 'superuser';
password = 'password';

Pra pegar o token dele precisa apenas fazer uma request para /api/login com esses dados:

```json
{
    "email": "superuser@email",
    "password": "password"
}
```
