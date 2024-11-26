# Use uma imagem oficial do PHP com suporte ao Apache
FROM php:8.1-apache

# Atualiza pacotes do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite

# Copia os arquivos da aplicação para o diretório root do Apache
COPY . /var/www/html

# Define as permissões apropriadas
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expõe a porta padrão do Apache
EXPOSE 80

# Inicia o servidor Apache
CMD ["apache2-foreground"]
