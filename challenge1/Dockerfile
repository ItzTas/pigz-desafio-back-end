FROM php:8.4-fpm-alpine

SHELL ["/bin/ash", "-eo", "pipefail", "-c"]

WORKDIR /app

COPY . .

RUN apk update


RUN curl -sS  https://raw.githubusercontent.com/composer/getcomposer.org/f3108f64b4e1c1ce6eb462b159956461592b3e3e/web/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer \
    composer install --no-dev --no-scripts --prefer-dist

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh'

CMD ["symfony", "server:start", "--port=8080"]
