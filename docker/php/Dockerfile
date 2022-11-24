FROM spiralscout/roadrunner:latest AS rr
FROM php:8.1-cli

RUN \
	apt-get -y update && \
    apt-get -y install git && \
    docker-php-ext-install mysqli pdo pdo_mysql sockets pcntl \
    && mkdir /code \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY --from=rr /usr/bin/rr /usr/bin/rr
#COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#
#ADD ./ /code/
#
#RUN cd /code && \
#    composer install && \
#    composer dump-autoload --optimize

#CMD ["/usr/bin/rr", "serve", "-c", "-"]

COPY /docker/php/roadrunner.sh /
RUN chmod +x /roadrunner.sh

CMD ["/roadrunner.sh"]
