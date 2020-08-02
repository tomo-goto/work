<?php

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT :
**************************************************************************/
function SQLGEN_set($array){

    // init
    $LC_SQL_str = 'set';
    $LC_cnt = 0;

    while( $LC_value = current($array) ){

        if( $LC_cnt > 0 ){
            $LC_SQL_str .= ',';
        }

        $LC_SQL_str = $LC_SQL_str . " " . key($array) . "=$LC_value";

        next($array);
        $LC_cnt++;
    }

    return $LC_SQL_str;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT :
**************************************************************************/
function SQLGEN_where($array){

/*
  $array = array(
             'COLUMN_NAME' => array(
               'ope'  => 'OPERATOR' // ex. "=", "&&"
               'data' => 'DATA'     // ex. "apple"
               )
           );
*/

    // init
    $LC_SQL_str = 'where';
    $LC_cnt = 0;

    while( $LC_value = current($array) ){

        if( $LC_cnt > 0 ){
            $LC_SQL_str .= ' and';
        }

        $LC_SQL_str = $LC_SQL_str . " " . key($array) . $LC_value['ope'] . $LC_value['data'];

        next($array);
        $LC_cnt++;
    }

    return $LC_SQL_str;
}

?>
