FROM php:7.3-fpm-alpine
RUN set -ex \
    && apk --no-cache add \
        postgresql-dev make \
    && docker-php-ext-install pdo \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql

RUN apk upgrade --no-cache --update && apk add\
     php7-simplexml \
     postgresql-dev \
     php7-xml \
     php7-xmlreader \
     php7-xmlwriter \
     libpng-dev \
     libjpeg-turbo-dev \
     libxpm-dev \
     freetype-dev \
     && docker-php-ext-install -j$(nproc) iconv \
     && docker-php-ext-configure gd \
              --with-freetype-dir=/usr/include/ \
              --with-jpeg-dir=/usr/include/ \
              --with-xpm-dir=/usr/include/ \
#              --with-vpx-dir=/usr/include/ \
     && docker-php-ext-install -j$(nproc) gd \
     && rm -rf /var/cache/apk/*

RUN apk add --no-cache --update $PHPIZE_DEPS --virtual buildDeps autoconf g++ \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del buildDeps

RUN docker-php-ext-install exif
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
