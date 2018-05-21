# See https://github.com/docker-library/php/blob/master/7.1/fpm/Dockerfile
FROM php:7.1-fpm
ARG TIMEZONE

MAINTAINER Maxence POUTORD <maxence.poutord@gmail.com>

RUN apt-get update && apt-get install -y \
    openssl \
    git \
    unzip \
    ruby-full \
    automake \
    libtool \
    nodejs \
    npm \
    build-essential \
    libssl-dev

RUN ln -s /usr/bin/nodejs /usr/bin/node
ENV NVM_DIR=/usr/bin
RUN curl https://raw.githubusercontent.com/creationix/nvm/master/install.sh | sh
RUN . "$NVM_DIR/nvm.sh" && nvm install 6.13.0

RUN gem update --system
RUN gem install capifony --no-user-install
RUN gem install sass --no-user-install
RUN cap --version

# install less
RUN npm install -g less

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# deployer
RUN curl -LO https://deployer.org/deployer.phar && mv deployer.phar /usr/local/bin/dep && chmod +x /usr/local/bin/dep
RUN dep --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www/symfony
