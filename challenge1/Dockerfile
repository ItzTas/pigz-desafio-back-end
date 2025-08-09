FROM php:8.4.11-fpm-alpine

WORKDIR /app/api

SHELL ["/bin/ash", "-eo", "pipefail", "-c"]

COPY . .

RUN apk update && apk add --no-cache git

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV PATH="$PATH:/usr/local/bin"

RUN composer install

# symfony
RUN apk add --no-cache bash && \
    curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash && \
    apk add --no-cache symfony-cli

# postgres plugin
RUN apk add --no-cache \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && docker-php-ext-enable pdo_pgsql

COPY ./scripts/init.sh /init.sh
RUN chmod +x /init.sh

CMD [ "bash", "/init.sh" ]

# CMD ["symfony", "server:start", "--port=8080", "--allow-all-ip"]
