<?php

/**
 * разделяет одну строку Nullable(UInt*) на две : UInt* и Nullable
 */
 function null_cut($type){

     global $type;
     global $null;

    //in php 8.0 str_starts_with()
     if (substr($type, 0,4) == 'Null'){

         $type = substr($type, 9,-1) ;
         $null = 'Nullable';
     }

    else {
        $null = 'NOTNullable';
    }


}
