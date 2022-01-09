<?php
//require  '../vendor/autoload.php';


class DBclickhouse
{

    function getConnection()
    {
        $config = [
            'host' => 'test_clickhouse',
            'port' => '8124',
            'database' => 'system',
            'username' => 'default',
            'password' => '12345'
        ];

        return $config;
    }

}