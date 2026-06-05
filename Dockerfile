FROM php:8.5-fpm

RUN apt-get update && apt-get install -y \
    curl \
    ca-certificates \
    libcurl4-openssl-dev \
    libzip-dev \
    libpq-dev \
    unzip \
    nginx \
    cron \
    rsyslog \
    supervisor \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    nodejs \
    npm && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql zip gd bcmath curl

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

# Composer
RUN curl -fsSL https://getcomposer.org/installer -o /tmp/composer-setup.php && \
    php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm -f /tmp/composer-setup.php && \
    composer --version

# Копируем конфигурацию Nginx (относительно папки docker в контексте ../)
COPY docker/nginx.conf /etc/nginx/conf.d/localhost.conf

# Копируем конфигурацию Supervisor (относительно папки docker в контексте ../)
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/crontab /etc/cron.d/my_cron_job
COPY docker/10-cron.conf /etc/rsyslog.d/10-cron.conf

RUN chmod 0644 /etc/cron.d/my_cron_job \
    && sed -i 's/\r$//' /etc/cron.d/my_cron_job \
    && touch /var/log/syslog \
    && chmod 644 /var/log/syslog \
    && touch /var/log/cron.log /var/log/cron-test.log \
    && chmod 666 /var/log/cron.log /var/log/cron-test.log

# Устанавливаем права доступа для директории
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Задаем рабочую директорию
WORKDIR /var/www/html

CMD /usr/bin/supervisord