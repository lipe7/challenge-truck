# Usa a imagem oficial do PHP como base
FROM php:8.1-fpm

# Instala dependências
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libssl-dev \
    && docker-php-ext-install pdo_mysql

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala as extensões PHP necessárias
RUN pecl install mongodb && docker-php-ext-enable mongodb
RUN pecl install redis && docker-php-ext-enable redis

# Define o diretório de trabalho
WORKDIR /var/www/html

# Adiciona o script wait-for-it.sh
ADD https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh

CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000