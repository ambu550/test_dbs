<?php
require_once("../config/DBclickhouse.php");
require_once("../config/TableBuilder.php");

$builder = new TableBuilder();

// подключение к КликХаусу
$conn = new DBclickhouse();
$db = new ClickHouseDB\Client($conn->getConnection());
$db->database('system');

// передаём массив полей которые хотим выгрузить
$fields_array =["database", "tables_count", "total_bytes"];
$fields = implode(",",$fields_array);


// параметры для Кликхауса
$input_params = [
    'fields' => $fields,
];

// запрос в Кликхаус
$statement = $db->select("
select 
database,COUNT(database) as tables_count,
SUM(total_bytes) as total_bytes
from system.tables
where database NOT IN ('system','INFORMATION_SCHEMA','information_schema')
GROUP BY database
ORDER BY database
", $input_params);
// результат запроса
$data=(["list" => $statement->rows()]);

echo "<h1>проверка базы CLICKHOUSE ---- ВСЕ схемы</h1>";

$builder->table_builder($data,$fields_array);


