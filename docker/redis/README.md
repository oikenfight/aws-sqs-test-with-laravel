# docker/redis/README.md

## パスワードの設定

[redis.conf](./usr/local/etc/redis/redis.conf) にて、 `requirepass ${REDIS_PASSWORD}` を用意してパスワードを使えるようにする。

実際には、 [docker-compose.yml](../../docker-compose.yml) の command で `envsubst` を用いて環境変数を置き換えるようにしている。

このため、 [Dockerfile](./Dockerfile) では、 `envsubst` を apk からインストールしている。

なお、 redis.conf は Dockerfile 中では redis.conf.template として配置するようにしている。

## 環境変数

環境変数は [.env.example](.env.example) を参考に、 `.env` として配置する。
