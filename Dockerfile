FROM lorisleiva/laravel-docker:7.2
RUN apk add grpc
EXPOSE 8000

WORKDIR /var/www/html

COPY .  /var/www/html
RUN rm -f composer.lock
RUN composer install
RUN cp .env.example .env
RUN php artisan key:generate


CMD php artisan --host=0.0.0.0 serve
