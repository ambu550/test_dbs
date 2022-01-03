FROM mcr.microsoft.com/mssql/server:2019-latest


# create directory within SQL container for database files
RUN mkdir -p /opt/mssql-scripts

# copy the database files from host to container
COPY setup.sql /opt/mssql-scripts

ENV ACCEPT_EULA=Y
ENV SA_PASSWORD=Test12345
ENV MSSQL_PID=Developer
ENV MSSQL_TCP_PORT=1433


RUN /opt/mssql/bin/sqlservr --accept-eula & sleep 10 \
    && /opt/mssql-tools/bin/sqlcmd -S localhost -U SA -P 'Test12345' -i /opt/mssql-scripts/setup.sql \
    && pkill sqlservr





