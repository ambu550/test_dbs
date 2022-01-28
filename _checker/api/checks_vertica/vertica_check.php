<?php
require  '../vendor/autoload.php';

$dsn = 'mysql:host=your_db_host;dbname=your_db_name;charset=utf8';
$usr = 'your_db_username';
$pwd = 'your_db_password';

$pdo = new \Rezon73\PDOVertica\Database($dsn, $usr, $pwd);

// SELECT * FROM users WHERE id = ?
$selectStatement = $pdo->select()
    ->from('users')
    ->where('id', '=', 1234);