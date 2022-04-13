<?php
require_once("../config/DBclickhouse.php");
require_once("../config/TableBuilder.php");
require_once("../config/Type_column.php");

// подключение к КликХаусу
$conn = new DBclickhouse();
$db = new ClickHouseDB\Client($conn->getConnection());
$db->database('system');


$schema = isset($_GET['schema']) ? $_GET['schema'] : die();




    print ("<h1>LIMITS CHECK  database: $schema  </h1>");



    $input_params_s = [
        'schema' => $schema,];
//получаем перечень таблиц в схеме
    $show_tables = $db->select("SHOW TABLES FROM {schema}", $input_params_s);

//количество таблиц в схеме
    $tables_count = $show_tables->count();

//перебираем каждую таблицу
    for ($i = 0; $i < $tables_count; $i++) {


//получаем название каждой колонки в схеме
        $table_name = ($show_tables->rows()[$i]["name"]);


            $input_params_t = [
                'schema' => $schema,
                'table' => $table_name];


//получаем описание каждой колонки в искомой таблице (только числовые) Массивы исключенны! (добавить децимал!)
                $show_columns = $db->select("select * from system.columns where database ='{$schema}'
                and `table` ='{$table_name}' and type like '%UInt%' and type not like '%Array%'", $input_params_t);

//функция проверки каждой колонки в искомой таблице на максимальное значение
                type_column($db, $schema, $table_name, $show_columns);


}