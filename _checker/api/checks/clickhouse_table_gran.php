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

// запрос в Кликхаус что бы получить поля
    $statement = $db->select("
SELECT {fields} FROM system.columns col
where  database = '{schema}'
AND table = '{table}'
ORDER BY {fields}
", $input_params);

$columns=($statement->rows());

for ($i=0; $i<count($columns) ; $i++) {

    if($i==0){

        $UNION = $UNION." SELECT '".$columns[$i]['name']."' as join_name, toString(min(".$columns[$i]['name']."))as min, toString(max(".$columns[$i]['name']."))as max FROM ".$schema.".".$table." \n";

    }else{

        $UNION = $UNION."UNION ALL SELECT '".$columns[$i]['name']."' as join_name, toString(min(".$columns[$i]['name']."))as min, toString(max (".$columns[$i]['name']."))as max FROM ".$schema.".".$table." \n";
    }

}


// параметры для Кликхауса
$input_params['UNION'] = $UNION;

// повторный на  кх запрос в Кликхаус
$statement = $db->select("
SELECT * FROM
(SELECT {fields} FROM system.columns col
where database = '{schema}'
AND table = '{table}'
ORDER BY position)c
LEFT JOIN
({UNION}) gen
on c.name=gen.join_name
", $input_params);






// результат запроса
    $data = (["list" => $statement->rows()]);

//добавляем min max
array_push($fields_array, "min", "max");
    echo "<h1>таблицa (".$schema.".".$table.") в CLICKHOUSE </h1>";

    $builder->table_builder($data, $fields_array);
