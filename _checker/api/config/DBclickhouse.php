<?php
require  '../vendor/autoload.php';
use Symfony\Component\Dotenv\Dotenv;
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

/**
 * подключение к бд ClickHouse
 */
class DBclickhouse
{

    function getConnection()
    {

        $config = [
            'host' => $_ENV['CLICKHOUSE_HOST'],
            'port' => $_ENV['CLICKHOUSE_PORT'],
            'database' => $_ENV['CLICKHOUSE_DATABASE'],
            'username' => $_ENV['CLICKHOUSE_USER'],
            'password' => $_ENV['CLICKHOUSE_PASSWORD']
        ];

        return $config;
    }

}