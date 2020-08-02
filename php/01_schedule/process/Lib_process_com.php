<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/

/**************************************************************************
FUNCTION_NAME : calculate_child_process_rate
DISCRIPTION   : 
          IN1 : array_daily   -> SQL result of "select * from todo_daily"
          IN1 : array_special -> SQL result of "select * from todo_special"
          IN2 : parent        -> key
          IN3 : child         -> key
          OUT : (int)
**************************************************************************/
function calculate_child_process_rate($array_daily, $array_special, $key_parent, $key_child){

    // Set SQL key
    $LC_col_parent   = 'big_task';
    $LC_col_child    = 'little_task';
    $LC_col_priority = 'priority';
    $LC_col_status   = 'status';

    $LC_pri_sum      = 0;
    $LC_pri_sum_done = 0;

    foreach($array_daily as $FE_row){

        if($FE_row[$LC_col_parent] == $key_parent && $FE_row[$LC_col_child] == $key_child){
            $LC_pri_sum += $FE_row[$LC_col_priority];
            
            if(strcmp($FE_row[$LC_col_status], 'done   ') == 0){
                $LC_pri_sum_done += $FE_row[$LC_col_priority];
            }
        }
    }

    foreach($array_special as $FE_row){

        if($FE_row[$LC_col_parent] == $key_parent && $FE_row[$LC_col_child] == $key_child){
            $LC_pri_sum += $FE_row[$LC_col_priority];
            
            if(strcmp($FE_row[$LC_col_status], 'done   ') == 0){
                $LC_pri_sum_done += $FE_row[$LC_col_priority];
            }
        }
    }

    if($LC_pri_sum == 0){
        return 0;
    }

    return $LC_pri_sum_done/$LC_pri_sum;
}

?>
