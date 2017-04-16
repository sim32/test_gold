FROM nginx:latest
RUN rm /etc/nginx/conf.d/default.conf

ADD config.conf /etc/nginx/conf.d/config.conf

RUN apt-get update
RUN apt-get install -y mc nano mysql-client

CMD nginx -g 'daemon off;'