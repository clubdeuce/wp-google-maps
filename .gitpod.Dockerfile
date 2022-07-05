FROM gitpod/workspace-mysql:2022-05-11-15-38-26

RUN sudo install-packages \
    php7.4 \
    php7.4-bcmath \
    php7.4-curl \
    php7.4-dev \
    php7.4-gd \
    php7.4-imagick \
    php7.4-intl \
    php7.4-mbstring \
    php7.4-mysql \
    php7.4-pspell \
    php7.4-redis \
    php7.4-xdebug \
    php7.4-zip

COPY files /

ENV NGINX_DOCROOT_IN_REPO="www"