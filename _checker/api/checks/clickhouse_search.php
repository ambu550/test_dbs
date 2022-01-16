<?php
require '../vendor/autoload.php';
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

$search = isset($_GET['search']) ? $_GET['search'] : die();
// параметры для Кликхауса
$input_params = [
    'fields' => $fields,
    'search' => $search
];

// запрос в Кликхаус
$statement = $db->select("
SELECT {fields} FROM system.columns col
where database not in ('system')
AND (database like'%{search}%' or table like'%{search}%' or name like'%{search}%')
ORDER BY {fields}
", $input_params);
// результат запроса
$data=(["list" => $statement->rows()]);

echo "<h1>проверка базы CLICKHOUSE</h1>";
echo '<p><a href='.'http://'.$_SERVER['HTTP_HOST'].'/checks/clickhouse_tables.php'.'>показать потаблично</a></p>';
echo '<p><a href='.'http://'.$_SERVER['HTTP_HOST'].'/checks/clickhouse_schemas.php'.'>показать посхемно</a></p>';


echo "<h3>Результаты поиска</h3>";
echo "
<form action='clickhouse_search.php' method=\"get\">
 <p>Поиск: <input type=\"text\" name=\"search\" value=\"$search\"/></p>
 <p><input type=\"submit\" /></p>
</form>";

$builder->table_builder($data,$fields_array);
