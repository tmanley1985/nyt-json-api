FROM nginx:1.25

ADD ./vhost.conf /etc/nginx/conf.d/default.conf
WORKDIR /var/www