FROM php:7.4-fpm

LABEL author="Montol Saklor"
LABEL maintainer="montolsaklor@gmail.com"
LABEL build_date="2018-10-05"

ENV TZ=Asia/Bangkok
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install dependencies
RUN apt-get update && apt-get install -y \
        autoconf \
	dpkg-dev \
        libfreetype6-dev \ 
        libicu-dev \ 
        libjpeg62-turbo-dev \ 
        libmcrypt-dev \ 
        libpng-dev \ 
        libxslt1-dev \ 
        sendmail-bin \ 
        sendmail \ 
        sudo \
        libonig-dev \
        libzip-dev \
        nodejs \
        npm

# Configure the gd library
RUN docker-php-ext-configure \
        gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/        

# Install required PHP extensions
RUN docker-php-ext-install \
        dom \ 
        gd \ 
        mbstring \ 
        pdo_mysql \ 
        zip \ 
        soap

# Install Composer
RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
        && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
        && php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" \
        && php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer --snapshot 

WORKDIR /var/www/
