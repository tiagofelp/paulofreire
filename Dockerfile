# Usa a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Label correta (evita o erro que você viu)
LABEL maintainer="tiago.felipe1403@outlook.com"

# Instala a extensão mysqli
RUN docker-php-ext-install mysqli

# Habilita o mod_rewrite (se necessário)
RUN a2enmod rewrite


# Copia os arquivos do repositório para a pasta padrão do Apache
COPY . /var/www/html/

# Dá permissão
RUN chown -R www-data:www-data /var/www/html

# Habilita o mod_rewrite, se necessário para URLs amigáveis
RUN a2enmod rewrite

# Porta padrão do Apache
EXPOSE 80
