FROM thecodingmachine/php:8.2-v4-apache-node18
ENV PHP_EXTENSION_LDAP=1
ENV PHP_EXTENSION_INTL=1
ENV COMPOSER_MEMORY_LIMIT=-1
ENV TZ=Europe/Berlin
USER root
RUN usermod -a -G www-data docker
#Do npm install
COPY package.json /var/www/html
COPY package-lock.json /var/www/html

USER docker
RUN composer install
USER root
#do all the directory stuff
RUN chown -R docker:docker var
USER docker