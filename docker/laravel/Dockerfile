FROM php:8.0-apache

# Instalar dependências do Laravel e extensão MongoDB
RUN docker-php-ext-install pdo pdo_mysql \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar o arquivo de configuração do Apache
COPY apache2.conf /etc/apache2/apache2.conf

# Copiar o VirtualHost do Laravel
COPY laravel.conf /etc/apache2/sites-available/laravel.conf

# Habilitar o VirtualHost
RUN a2ensite laravel

# Reiniciar o Apache
RUN service apache2 restart

# Setar o diretório de trabalho
WORKDIR /var/www/html
