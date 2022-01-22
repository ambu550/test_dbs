<?php
require_once("../config/DBclickhouse.php");
require_once("TableBuilder.php");

$builder = new TableBuilder();

// подключение к КликХаусу
$conn = new DBclickhouse();
$db = new ClickHouseDB\Client($conn->getConnection());
$db->database('system');

// передаём массив полей которые хотим выгрузить
$fields_array =["database", "table", "name", "type", "comment"];
$fields = implode(",",$fields_array);


// параметры для Кликхауса
$input_params = [
    'fields' => $fields,
];

// запрос в Кликхаус
$statement = $db->select("
SELECT {fields} FROM system.columns col
where database NOT IN ('system','INFORMATION_SCHEMA','information_schema')
ORDER BY {fields}
", $input_params);
// результат запроса
$data=(["list" => $statement->rows()]);

echo "<h1>проверка базы CLICKHOUSE</h1>";

echo "<h3>Полное инфо для поиска</h3>";
echo "
<form action='clickhouse_search.php' method=\"get\">
 <p>Поиск: <input type=\"text\" name=\"search\"  placeholder=\"имя схемы или таблицы\" title='частичный поиск по имени схемы и\или таблицы'/></p>
 <p><input type=\"submit\" value=\"Искать\" /></p>
</form>";

$builder->table_builder($data,$fields_array);

