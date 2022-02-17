<?php

class DBpostgresql
{

    function getConnection()
    {
   //     echo "\n Start connect...\n";
        $c_conn= pg_connect(
            "host=test_postgresql
        port=5432 
        dbname=public 
        user=alex 
        password=1234")
       ;// or die('Не удалось соединиться: ' . pg_last_error())


        $stat = pg_connection_status($c_conn);
        if ($stat === PGSQL_CONNECTION_OK) {
            return $c_conn;
        } else {
            echo "<h1>Статус соединения: разорвано </h1>";
            die();
        }

    }

}


