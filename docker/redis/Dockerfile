FROM redis:3.0-alpine

COPY docker/redis/usr/local/etc/redis/redis.conf /usr/local/etc/redis/redis.conf.template

RUN apk --no-cache add libintl && \
    apk --no-cache add --virtual .gettext gettext && \
    cp /usr/bin/envsubst /usr/local/bin/envsubst && \
    apk del .gettext

# docker-compose.yml の command にて envsubst を用いて起動するように作ったため、本ファイルの CMD は用いない
#CMD ["redis-server", "/usr/local/etc/redis/redis.conf" ]
