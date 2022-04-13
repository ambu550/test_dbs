<?php

function type_column($db, $schema, $table_name, $show_columns)
{
    require_once("Null_cut.php");
    require_once("Cut_data.php");

global $type;
global $null;
global $max_UI;


//считаем количество колонок в таблице
    $columns_count = $show_columns->count();
  //  print_r($table_name." has columns: ".$columns_count."\n");

//перебираем каждую колонку в таблице
    for ($i = 0; $i < $columns_count; $i++) {

        $column = ($show_columns->rows()[$i]['name']);
 //тип данных в колонке
        $type = ($show_columns->rows()[$i]['type']);


        $input_params_c = [
            'schema' => $schema,
            'table' => $table_name,
            'column' => $column];

//определяем текущее максимальное значение в колонке
        $statement = $db->select("SELECT max({column}) FROM {schema}.{table}", $input_params_c);
        $ch_max = ($statement->rows()[0]["max($column)"]);

//распарсиваем тип и Nullable
        null_cut($type);

//поиск максимального возможного значения(порог) для типа данных искомой колонки
        cut_data_check($type);

//проверка где максимальные данные упираются в порог
        if($ch_max == $max_UI) {
            $cut_data_test = 'FAIL';
            print_r("<p>$schema,$table_name,$column,$type,$null,$ch_max,$cut_data_test\n\n</p>");
            print_r("\n");
        } else {
            $cut_data_test = 'PASS';
        }


     //   print_r($schema . ' ' . $table_name . ' ' . $column . ' ' . $type. ' ' .$null. ' ' . $ch_max .' '.$cut_data_test. "\n");

 /*
    Дополнения
    1) сравнение с максимальным UInt* колонки (если срезает) -done
    2) Поиск где нет нуловых данных но поле Нулл
    3) сравнение с максимальным UInt* ниже по количеству (оптимизация хранения)
    4) Проверка типа и максимального значения в источнике
    5) проверка типа данных в источнике (SELECT  * FROM information_schema.columns where table_name = 'ttn' +название колонки)
*/
    }
}
