<?php
require_once("../config/DBclickhouse.php");
require_once("TableBuilder.php");

$builder = new TableBuilder();

// подключение к КликХаусу
$conn = new DBclickhouse();
$db = new ClickHouseDB\Client($conn->getConnection());
$db->database('system');

// передаём массив полей которые хотим выгрузить
$fields_array =["database","table","total_rows","total_bytes" ,"engine_full"];
$fields = implode(",",$fields_array);


// параметры для Кликхауса
$input_params = [
    'fields' => $fields,
];

// запрос в Кликхаус
$statement = $db->select("
SELECT {fields}
FROM system.tables
LEFT JOIN
( select database ,table from system.columns group by  database ,table)c
ON name =c.table
WHERE database not in ('system')
", $input_params);

// результат запроса
$data=(["list" => $statement->rows()]);


echo "<h1>таблицы в CLICKHOUSE</h1>";

$builder->table_builder($data,$fields_array);
