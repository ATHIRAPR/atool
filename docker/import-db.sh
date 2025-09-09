###To import MSSQL DB
docker exec -it mssql_2017 /opt/mssql-tools/bin/sqlcmd -S localhost -U sa -P 'LocalDB!@#123' -Q "RESTORE FILELISTONLY FROM DISK = N'/tmp/admin-tool-MTINFO.bak'"

/opt/mssql-tools/bin/sqlcmd -S localhost -U sa -P 'LocalDB!@#123' -Q "
RESTORE DATABASE localdb
FROM DISK = N'/tmp/admin-tool-MTINFO.bak'
WITH MOVE 'MTINFO' TO '/var/opt/mssql/data/MTINFO.mdf',
     MOVE 'MTINFO_log' TO '/var/opt/mssql/data/MTINFO_log.ldf',
     REPLACE;"