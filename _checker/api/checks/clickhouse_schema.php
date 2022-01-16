<?php
require_once("../config/DBclickhouse.php");
require_once("TableBuilder.php");

$builder = new TableBuilder();

// подключение к КликХаусу
$conn = new DBclickhouse();
$db = new ClickHouseDB\Client($conn->getConnection());
$db->database('system');

// передаём массив полей которые хотим выгрузить
$fields_array =["database", "tables_count", "total_bytes"];
$fields = implode(",",$fields_array);

//принимаем аргумент GET запроса
$schema = isset($_GET['schema']) ? $_GET['schema'] : die();

// параметры для Кликхауса
$input_params = [
    'fields' => $fields,
    'schema' => $schema
];

// запрос в Кликхаус
$statement = $db->select("
select 
database,COUNT(database) as tables_count,
SUM(total_bytes) as total_bytes
from system.tables
where database NOT IN ('system')
GROUP BY database
HAVING database ='{schema}'
", $input_params);
// результат запроса
$data=(["list" => $statement->rows()]);

echo "<h1>проверка базы CLICKHOUSE (схема ".$schema.")</h1>";

$builder->table_builder($data,$fields_array);
echo "<h1></h1>";


// передаём массив полей которые хотим выгрузить
$fields_array =["database","table","total_rows","total_bytes" ,"engine_full"];
$fields = implode(",",$fields_array);


// параметры для Кликхауса
$input_params = [
    'fields' => $fields,
    'schema' => $schema
];

// запрос в Кликхаус
$statement = $db->select("
SELECT {fields}
FROM system.tables
LEFT JOIN
( select database ,table from system.columns group by  database ,table)c
ON name =c.table
WHERE database not in ('system')
AND database = '{schema}'
", $input_params);

// результат запроса
$data=(["list" => $statement->rows()]);
$builder->table_builder($data,$fields_array);
