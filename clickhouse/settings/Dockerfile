FROM yandex/clickhouse-server:21.11.10.1


ENV CLICKHOUSE_DB=ch_database
ENV CLICKHOUSE_USER=default
ENV CLICKHOUSE_PASSWORD=12345
ADD init-db.sql /docker-entrypoint-initdb.d/init-db.sql

ADD users.xml /etc/clickhouse-server/users.xml
ADD config.xml /etc/clickhouse-server/config.xml
ADD conf_client.xml /etc/clickhouse-client/config.xml