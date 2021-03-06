<?php

class TableBuilder


{
public function table_builder($data,$fields_array, $links=true){
    if ($links===true) {
        echo '<p><a href=' . 'http://' . $_SERVER['HTTP_HOST'] . '>вернуться на главную</a></p>';
        echo '<p><a href=' . 'http://' . $_SERVER['HTTP_HOST'] . '/checks/clickhouse_tables.php' . '>показать потаблично</a></p>';
        echo '<p><a href=' . 'http://' . $_SERVER['HTTP_HOST'] . '/checks/clickhouse_schemas.php' . '>показать посхемно</a></p>';
    }

    // формимруем таблицу если есть результат
    if (count($data["list"])) {
        echo '<head>';
        echo '<meta charset="UTF-8">';
        //echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.1.2/dist/css/bootstrap.min.css">';
        echo '</head>';

        echo'<body link="#0000FF" vlink="#0000FF" alink="#0000FF">';
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
                switch ($value) {
                    //если колонка со названием схемы генерировать ссылку с переходом на конкретную схему
                    case "database":
                        echo '<td><a href='.'http://'.$_SERVER['HTTP_HOST'].'/checks/clickhouse_schema.php?schema='.$list[$value].'>'.$list[$value]."</a></td>";
                        break;
                    //если колонка с названием таблицы генерировать ссылку с переходом на конкретную таблицу
                    case "table":
                        echo '<td><a href='.'http://'.$_SERVER['HTTP_HOST'].'/checks/clickhouse_table.php?schema='.$list['database'].'&table='.$list[$value].'>'.$list[$value]."</a></td>";
                        break;
                    default:
                        echo "<td>".$list[$value]."</td>";
                }
            }
            echo "</tr>";

        }

        // Close the table
        echo "</table>";
        echo "</body>";
    }
}
}