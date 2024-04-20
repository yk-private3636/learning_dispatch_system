FROM php:8.2-apache
RUN apt-get update && apt-get install -y libonig-dev && docker-php-ext-install pdo_mysql
RUN cd /usr/local/bin && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php && mv ./composer.phar ./composer && php -r "unlink('composer-setup.php');"
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs
RUN apt-get -y install \
unzip \
vim
RUN cd /etc/apache2/mods-enabled \
    && ln -s ../mods-available/rewrite.load
#RUN /etc/init.d/apache2 reload
COPY ./apache2.conf /etc/apache2/apache2.conf
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./php.ini /usr/local/etc/php/php.ini

COPY ./create_htpasswd.sh /tmp/create_htpasswd.sh
RUN chmod 755 /tmp/create_htpasswd.sh
RUN /tmp/create_htpasswd.sh

WORKDIR /var/www/html/learning_dispatch_system


