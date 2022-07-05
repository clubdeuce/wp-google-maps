FROM gitpod/workspace-full

RUN sudo install-packages \
    php8.1-xdebug 

COPY files /

ENV NGINX_DOCROOT_IN_REPO="www"