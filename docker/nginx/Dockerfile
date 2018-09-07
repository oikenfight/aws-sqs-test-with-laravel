FROM nginx:alpine

# ツールをインストール
RUN apk --no-cache update && \
    apk --no-cache upgrade && \
    apk --no-cache add \
    openssl

COPY docker/nginx/etc/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/etc/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

# 自己証明書を発行
RUN openssl genrsa 2048 > server.key \
 && openssl req -new -key server.key -subj "/C=JP/ST=Tokyo/L=Chuo-ku/O=RMP Inc./OU=web/CN=localhost" > server.csr \
 && openssl x509 -in server.csr -days 3650 -req -signkey server.key > server.crt \
 && cp server.crt /etc/nginx/server.crt \
 && cp server.key /etc/nginx/server.key \
 && chmod 400 /etc/nginx/server.key
