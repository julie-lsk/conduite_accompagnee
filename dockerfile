FROM php:8.0-apache

# Installe l'extension pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql