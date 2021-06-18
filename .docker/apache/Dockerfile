ARG APACHE_VERSION=""
FROM httpd:${APACHE_VERSION:+${APACHE_VERSION}-}alpine

RUN apk update; \
    apk upgrade;

# Copy apache vhost file to proxy php requests to php-fpm container
COPY .docker/apache/custom.conf /usr/local/apache2/conf/custom.conf

# TODO: stuff related to SSL has been commented out; uncomment once needed
#RUN apk add --no-cache apache2-ssl

# Copy https certs to server
#COPY .docker/apache/server.crt /usr/local/apache2/conf/server.crt
#COPY .docker/apache/server.key /usr/local/apache2/conf/server.key

# Enable apache modules and ssl conf
RUN sed -i \
        #-e 's/^#\(Include .*httpd-ssl.conf\)/\1/' \
        #-e 's/^#\(LoadModule .*mod_ssl.so\)/\1/' \
        -e 's/^#\(LoadModule .*mod_socache_shmcb.so\)/\1/' \
        -e 's/^#\(LoadModule .*mod_rewrite.so\)/\1/' \
        -e 's/^#\(LoadModule .*mod_proxy.so\)/\1/' \
        -e 's/^#\(LoadModule .*mod_proxy_fcgi.so\)/\1/' \
        -e 's#AllowOverride [Nn]one#AllowOverride All#' \
        /usr/local/apache2/conf/httpd.conf

RUN echo "Include /usr/local/apache2/conf/custom.conf" \
    >> /usr/local/apache2/conf/httpd.conf

WORKDIR /var/www/html
