FROM nginx:alpine

ADD dockerConfig/http/vhost.conf /etc/nginx/conf.d/default.conf
