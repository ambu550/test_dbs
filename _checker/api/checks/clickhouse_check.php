<?php
require '../vendor/autoload.php';
require_once("../config/DBclickhouse.php");

// подключение к КликХаусу
$conn = new DBclickhouse();
$db = new ClickHouseDB\Client($conn->getConnection());
$db->database('system');

// передаём массив полей которые хотим выгрузить
$fields_array =["database", "table", "name", "type"];
$fields = implode(",",$fields_array);


// параметры для Кликхауса
$input_params = [
    'fields' => $fields,
];

// запрос в Кликхаус
$statement = $db->select("
SELECT {fields} FROM system.columns
where database not in ('system')
ORDER BY {fields}
", $input_params);
// результат запроса
$data=(["list" => $statement->rows()]);

echo "<h1>проверка базы CLICKHOUSE</h1>";

// формимруем таблицу если есть результат
if (count($data["list"])) {
    // Open the table
    echo "<table border=1>";

    // формимруем заголовки табицы
    foreach ($fields_array as $value) {
        echo "<th>".$value."</th>";
    }

    // формимруем данные в таблице
    foreach ($data["list"] as $idx => $list) {

        // Output a row
        echo "<tr>";
        foreach ($fields_array as $value) {
            echo "<td>".$list[$value]."</td>";
        }
        echo "</tr>";
    }

    // Close the table
    echo "</table>";
}

