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

//TODO min max generator
/*
SELECT * FROM
(select name from system.columns
where `table` ='ch_managers'
and name='id')c
LEFT JOIN
(select 'id' as col, max(id) as m,max(id)as m2 from test.ch_managers
GROUP by col) gen
on c.name=gen.col
*/

//// запрос в Кликхаус на названия колонок для мапппинга
//$column_info = $db->select("
//SELECT name FROM system.columns col
//where database not in ('system')
//  AND database = '{schema}'
//AND table = '{table}'
//", $input_params);
//
//$columns=(["list" => $column_info->rows()]);
//$UNION='';
//foreach ($columns["list"] as $idx => $list) {
//    $i=0;
//    echo $i;
//        if($i==0){
//            echo $i;
//            $UNION = $UNION." SELECT ".$list['name'].", min(".$list['name']."), max (".$list['name'].") FROM ".$schema.".".$table."\n";
//            $i =1;
//            echo $i;
//        }else{
//            echo $i;
//            $UNION = $UNION."UNION ALL SELECT ".$list['name'].", min(".$list['name']."), max (".$list['name']." FROM ".$schema.".".$table."\n";
//        }
//
//}
//echo $UNION;

// запрос в Кликхаус
    $statement = $db->select("
SELECT {fields} FROM system.columns col
where database not in ('system')
  AND database = '{schema}'
AND table = '{table}'
ORDER BY {fields}
", $input_params);

// результат запроса
    $data = (["list" => $statement->rows()]);


    echo "<h1>таблицa (".$schema.".".$table.") в CLICKHOUSE </h1>";

    $builder->table_builder($data, $fields_array);
