<?php
require_once("../config/DBclickhouse.php");
require_once("../config/TableBuilder.php");


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

// запрос в Кликхаус что бы получить поля по которым имеет смысл считать границы
    $statement = $db->select("
SELECT {fields} FROM system.columns col
where  database = '{schema}'
AND table = '{table}'
AND 
  ( type ILIKE '%Int8%'
    OR type ILIKE '%Int16%'
    OR type ILIKE '%Int32%'
    OR type ILIKE '%Int64%'
    OR type ILIKE '%Date%'
    )
AND type NOT ILIKE '%Array%'
ORDER BY {fields}
", $input_params);


$columns=($statement->rows());

//защита если вдруг не будет нумеровых колонок и нечего будет джойнить

for ($i=0; $i<count($columns) ; $i++) {

    if($i==0){

        $UNION = $UNION." SELECT '".$columns[$i]['name']."' as join_name, toString(min(".$columns[$i]['name'].")) as min, toString(max(".$columns[$i]['name'].")) as max FROM ".$schema.".".$table." \n";

    }else{

        $UNION = $UNION."UNION ALL SELECT '".$columns[$i]['name']."' as join_name, toString(min(".$columns[$i]['name'].")) as min, toString(max (".$columns[$i]['name'].")) as max FROM ".$schema.".".$table." \n";
    }

}

//защита если вдруг не будет нумеровых колонок и нечего будет джойнить

if (count($columns) === 0) {
    $statement = $db->select("
SELECT {fields} FROM system.columns col
where database = '{schema}'
AND table = '{table}'
ORDER BY position
", $input_params);
    echo "<h5>нет колонок для просчёта граничных значений (Int\UInt\Date\DateTime) </h5>";
} else {

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
}


// результат запроса
    $data = (["list" => $statement->rows()]);

//добавляем min max
array_push($fields_array, "min", "max");
    echo "<h1>таблицa (".$schema.".".$table.") в CLICKHOUSE </h1>";

    $builder->table_builder($data, $fields_array);

