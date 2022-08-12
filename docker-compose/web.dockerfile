FROM nginx:1.10-alpine

ADD docker-compose/nginx/default.conf /etc/nginx/conf.d/default.conf


COPY public /var/www/public