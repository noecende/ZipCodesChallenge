FROM openswoole/swoole:4.11-php8.0

ARG COMPOSER_HASH
ENV COMPOSER_HASH=${COMPOSER_HASH}

COPY composer.json composer.lock /var/www/


COPY database /var/www/database


WORKDIR /var/www


RUN apt-get update && apt-get -y install git && apt-get -y install zip


RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php -r "if (hash_file('sha384', 'composer-setup.php') === '${COMPOSER_HASH}') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"\
&& php composer-setup.php \
&& php -r "unlink('composer-setup.php');" \
&& mv /var/www/composer.phar /usr/local/bin/composer \
&& composer install --no-scripts

COPY . /var/www

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

RUN chmod -R 777 /var/www/storage

RUN apt-get install -y libmcrypt-dev  libmagickwand-dev --no-install-recommends
RUN docker-php-ext-install mysqli pdo pdo_mysql pcntl
RUN docker-php-ext-enable openswoole
RUN docker-php-ext-enable pcntl
RUN apt-get install nodejs -y
RUN apt-get install npm -y
RUN npm install 
RUN npm install --save-dev chokidar
