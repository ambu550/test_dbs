<?php

/**
 * проверка что максимальное значение в КликХаусе не упирается в максимальное возможное значение
 */
 function cut_data_check($type): int
 {
     $UInt8_max = 255;
     $UInt16_max = 65535;
     $UInt32_max = 4294967295;
     $UInt64_max = 18446744073709551615;
     $Int8_max = 127;
     $Int16_max = 32767;
     $Int32_max = 2147483647;
     $Int64_max = 9223372036854775807;


    global $type;
    global $max_UI;

   switch ($type) {
       case 'UInt8':
           $max_UI = $UInt8_max;
           break;
       case 'UInt16':
           $max_UI = $UInt16_max;
           break;
       case 'UInt32':
           $max_UI = $UInt32_max;
           break;
       case 'UInt64':
           $max_UI = $UInt64_max;
           break;
       default:
           break;
   }

     return $max_UI;

}