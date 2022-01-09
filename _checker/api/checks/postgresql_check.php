<?php
require '../vendor/autoload.php';
require_once("../config/DBpostgresql.php");




// подключение к Постгрес
$conn = new DBpostgresql();
$dbconn = $conn->getConnection();

//// передаём массив полей которые хотим выгрузить
$fields_array =["table_schema", "table_name","ordinal_position", "column_name"];
$fields = implode(",",$fields_array);

// результат запроса
$res_query = pg_query($dbconn,
    "select $fields
from information_schema.columns
where table_schema in ('public')
ORDER BY $fields");



echo "<h1>проверка базы PostgreSQL</h1>";

// формимруем таблицу если есть результат
if (pg_num_rows($res_query)) {
    // Open the table
    echo "<table border=1>";

    // формимруем заголовки табицы
    foreach ($fields_array as $value) {
        echo "<th>".$value."</th>";
    }

    // формимруем данные в таблице
    for ($i=0; $i<pg_num_rows($res_query); $i++) {

        $row=pg_fetch_array($res_query,$i);
        // Output a row
        echo "<tr>";

        foreach ($fields_array as $value) {
            echo "<td>".$row[$value]."</td>";

        }
        echo "</tr>";

    }

    // Close the table
    echo "</table>";
}

