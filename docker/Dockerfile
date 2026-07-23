FROM php:8.3-cli-bookworm

# The default sources use plain HTTP to a Fastly-fronted mirror that is
# intermittently unreachable from some Docker networks; HTTPS is more
# reliable here, combined with retries below.
RUN sed -i 's#http://deb.debian.org#https://deb.debian.org#g' /etc/apt/sources.list.d/*.sources

RUN set -e; \
    n=0; until [ $n -ge 8 ]; do apt-get update && break; n=$((n+1)); echo "apt-get update retry $n"; sleep 6; done; \
    n=0; until [ $n -ge 8 ]; do apt-get install -y --no-install-recommends \
        git unzip libzip-dev libpng-dev libonig-dev libxml2-dev libicu-dev curl gnupg default-mysql-client \
        && break; n=$((n+1)); echo "apt-get install retry $n"; sleep 6; done; \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl; \
    n=0; until [ $n -ge 8 ]; do curl -fsSL https://deb.nodesource.com/setup_20.x -o /tmp/nodesource_setup.sh && break; n=$((n+1)); echo "nodesource fetch retry $n"; sleep 6; done; \
    bash /tmp/nodesource_setup.sh; \
    n=0; until [ $n -ge 8 ]; do apt-get install -y nodejs && break; n=$((n+1)); echo "nodejs install retry $n"; sleep 6; done; \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
    apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["entrypoint.sh"]
