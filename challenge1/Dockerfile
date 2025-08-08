FROM php:8.4.11-fpm-alpine

WORKDIR /app/api

SHELL ["/bin/ash", "-eo", "pipefail", "-c"]

COPY . .

RUN apk update && apk add --no-cache git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV PATH="$PATH:/usr/local/bin"

RUN composer install

RUN apk add --no-cache bash && \
    curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash && \
    apk add --no-cache symfony-cli

CMD ["symfony", "server:start", "--port=8080", "--allow-all-ip"]

