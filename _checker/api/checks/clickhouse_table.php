<?php
require_once("../config/DBclickhouse.php");
require_once("TableBuilder.php");


    // подключение к КликХаусу
    $conn = new DBclickhouse();
    $db = new ClickHouseDB\Client($conn->getConnection());
    $db->database('system');
    $builder = new TableBuilder();

// передаём массив полей которые хотим выгрузить
    $fields_array =["database", "table", "position", "name", "type", "comment"];
    $fields = implode(",", $fields_array);


//принимаем аргументы GET запроса
$table = isset($_GET['table']) ? $_GET['table'] : die();
$schema = isset($_GET['schema']) ? $_GET['schema'] : die();


// параметры для Кликхауса
$input_params = [
    'fields' => $fields,
    'table' => $table,
    'schema' => $schema
];

// запрос в Кликхаус
    $statement = $db->select("
SELECT {fields} FROM system.columns col
where  database = '{schema}'
AND table = '{table}'
ORDER BY {fields}
", $input_params);


// результат запроса
    $data = (["list" => $statement->rows()]);


    echo "<h1>таблицa (".$schema.".".$table.") в CLICKHOUSE </h1>";
    echo '<h3><a href='.'http://'.$_SERVER['HTTP_HOST'].'/checks/clickhouse_table_gran.php?schema='.$schema.'&table='.$table.'>расчитать граничные значения</a></h3>';

    $builder->table_builder($data, $fields_array);
