<?php

class TableBuilder
{
public function table_builder($data,$fields_array){
    echo '<a href='.'http://'.$_SERVER['HTTP_HOST'].'>вернуться на главную</a>';
    // формимруем таблицу если есть результат
    if (count($data["list"])) {
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
                        echo '<td><a href='.'http://'.$_SERVER['HTTP_HOST'].'/checks/clickhouse_table.php?table='.$list[$value].'&schema='.$list['database'].'>'.$list[$value]."</a></td>";
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