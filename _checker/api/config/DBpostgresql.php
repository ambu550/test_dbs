<?php
use Symfony\Component\Dotenv\Dotenv;
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

class DBpostgresql
{

    function getConnection()
    {
   //     echo "\n Start connect...\n";
        $c_conn= pg_connect(
            "host=".$_ENV['POSTGRES_HOST'].
        " port=".$_ENV['POSTGRES_PORT'].
        " dbname=".$_ENV['POSTGRES_DB'].
        " user=".$_ENV['POSTGRES_USER'].
        " password=".$_ENV['POSTGRES_PASSWORD'])
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


