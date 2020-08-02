<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/

require_once(dirname(__FILE__) . '/../common/DB2.php');

    // tag name
    $LC_tag = 'ins_tag';

    // switch by tag
    switch($_POST[$LC_tag]){
        case 'ins_parent':
        insert_parent($_POST);
        break;
        case 'ins_child':
        insert_child($_POST);
        break;
        case 'ins_daily':
        insert_daily($_POST);
        break;
        case 'ins_special':
        insert_special($_POST);
        break;
        case 'ins_littleimp':
        insert_little_impression($_POST);
        break;
    }

    if( isset($_POST[$LC_tag] )){
        $uri = $_SERVER['HTTP_REFERER'];
        header("Location: ". $uri);
        exit;
    }

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function execute_insert(){

    // switch by tag
    switch($_POST['ins_tag']){
        case 'ins_parent':
        insert_parent($_POST);
        break;
        case 'ins_child':
        insert_child($_POST);
        break;
        case 'ins_daily':
        insert_daily($_POST);
        break;
        case 'ins_special':
        insert_special($_POST);
        break;
        case 'ins_littleimp':
        insert_little_impression($_POST);
        break;
    }

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function insert_parent($data){

    // set Data
    $LC_parent = $data['ins_parent'];

    if( empty($LC_parent) ){
        // ERROR
    }

    // Set SQL key
    $LC_table = 'p_task';

    $LC_SQL_VALUES = $LC_parent;

    // SQL query
    db_insert($LC_table, $LC_SQL_VALUES);

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function insert_child($data){

    // set Data
    $LC_parent = $data['ins_parent'];
    $LC_child  = $data['ins_child'];
    $LC_start  = $data['ins_start'];
    $LC_end    = $data['ins_end'];
    $LC_goal   = $data['ins_goal'];
    $LC_comp   = '';

    if( empty($LC_parent) || empty($LC_child) ){
        // ERROR
    }
    else if( empty($LC_start) || empty($LC_end) || empty($LC_goal) ){
        // ERROR
    }

    // Set SQL key
    $LC_table = 'c_task';

    $LC_SQL_VALUES = "'$LC_child','[$LC_start,$LC_end)'::daterange,'$LC_goal','$LC_comp','$LC_parent'";

    // SQL query
    db_insert($LC_table, $LC_SQL_VALUES);

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function insert_daily($data){

    // set Data
    $LC_parent = $data['ins_parent'];
    $LC_child  = $data['ins_child'];
    $LC_todo   = $data['ins_todo'];
    $LC_obs    = '';
    $LC_status = $data['ins_status'];
    $LC_pri    = $data['ins_pri'];
    $LC_todo_s = $data['ins_todo_start'];
    $LC_todo_e = $data['ins_todo_end'];

    $LC_mon_s  = $data['ins_mon_start'];
    $LC_mon_e  = $data['ins_mon_end'];
    $LC_tue_s  = $data['ins_tue_start'];
    $LC_tue_e  = $data['ins_tue_end'];
    $LC_wed_s  = $data['ins_wed_start'];
    $LC_wed_e  = $data['ins_wed_end'];
    $LC_thu_s  = $data['ins_thu_start'];
    $LC_thu_e  = $data['ins_thu_end'];
    $LC_fri_s  = $data['ins_fri_start'];
    $LC_fri_e  = $data['ins_fri_end'];
    $LC_sat_s  = $data['ins_sat_start'];
    $LC_sat_e  = $data['ins_sat_end'];
    $LC_sun_s  = $data['ins_sun_start'];
    $LC_sun_e  = $data['ins_sun_end'];

    if( empty($LC_parent) || empty($LC_child) || empty($LC_todo) ){
        // ERROR
    }
    else if( empty($LC_status) || empty($LC_pri) || empty($LC_todo_s) || empty($LC_todo_e) ){
        // ERROR
    }

    // SQL for wday
    $LC_wday = '';

    // Monday
    if( empty($LC_mon_s) || empty($LC_mon_e) ){
        $LC_wday = "null,";
    }
    else{
        $LC_wday = "'(1970-1-1 $LC_mon_s,1970-1-1 $LC_mon_e)'::tsrange,";
    }

    // Tuesday
    if( empty($LC_tue_s) || empty($LC_tue_e) ){
        $LC_wday .= "null,";
    }
    else{
        $LC_wday .= "'(1970-1-1 $LC_tue_s,1970-1-1 $LC_tue_e)'::tsrange,";
    }

    // Wednesday
    if( empty($LC_wed_s) || empty($LC_wed_e) ){
        $LC_wday .= "null,";
    }
    else{
        $LC_wday .= "'(1970-1-1 $LC_wed_s,1970-1-1 $LC_wed_e)'::tsrange,";
    }

    // Thursday
    if( empty($LC_thu_s) || empty($LC_thu_e) ){
        $LC_wday .= "null,";
    }
    else{
        $LC_wday .= "'(1970-1-1 $LC_thu_s,1970-1-1 $LC_thu_e)'::tsrange,";
    }

    // Friday
    if( empty($LC_fri_s) || empty($LC_fri_e) ){
        $LC_wday .= "null,";
    }
    else{
        $LC_wday .= "'(1970-1-1 $LC_fri_s,1970-1-1 $LC_fri_e)'::tsrange,";
    }

    // Saturday
    if( empty($LC_sat_s) || empty($LC_sat_e) ){
        $LC_wday .= "null,";
    }
    else{
        $LC_wday .= "'(1970-1-1 $LC_sat_s,1970-1-1 $LC_sat_e)'::tsrange,";
    }

    // Sunday
    if( empty($LC_sun_s) || empty($LC_sun_e) ){
        $LC_wday .= "null";
    }
    else{
        $LC_wday .= "'(1970-1-1 $LC_sat_s,1970-1-1 $LC_sat_e)'::tsrange";
    }

    // Set SQL key
    $LC_table = 'todo_daily';

    $LC_SQL_VALUES = "'$LC_todo','$LC_obs','$LC_status',$LC_pri,'[$LC_todo_s,$LC_todo_e)'::daterange,$LC_wday,'$LC_parent','$LC_child'";

    // SQL query
    db_insert($LC_table, $LC_SQL_VALUES);

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function insert_special($data){

    // set Data
    $LC_parent = $data['ins_parent'];
    $LC_child  = $data['ins_child'];
    $LC_todo   = $data['ins_todo'];
    $LC_obs    = '';
    $LC_status = $data['ins_status'];
    $LC_pri    = $data['ins_pri'];
    $LC_start  = $data['ins_todo_start_ts'];
    $LC_end    = $data['ins_todo_end_ts'];

    if( empty($LC_parent) || empty($LC_child) || empty($LC_todo) ){
        // ERROR
    }
    else if( empty($LC_status) || empty($LC_pri) || empty($LC_start) || empty($LC_end) ){
        // ERROR
    }

    $LC_start = str_replace('T',' ',$LC_start);
    $LC_end   = str_replace('T',' ',$LC_end);

    // Set SQL key
    $LC_table = 'todo_special';

    $LC_SQL_VALUES = "'$LC_todo','$LC_obs','$LC_status',$LC_pri,'($LC_start,$LC_end)'::tsrange,'$LC_parent','$LC_child'";

    // SQL query
    db_insert($LC_table, $LC_SQL_VALUES);

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function insert_little_impression($data){

    // set Data
    $LC_parent = $data['ins_parent'];
    $LC_child  = $data['ins_child'];
    $LC_title  = $data['ins_title'];
    $LC_litimp = $data['ins_litimp'];

    if( empty($LC_parent) || empty($LC_child) ){
        // ERROR
    }
    else if( empty($LC_title) || empty($LC_litimp) ){
        // ERROR
    }

    // Set SQL key
    $LC_table = 'little_impression';

    $LC_SQL_VALUES = "'$LC_title','$LC_litimp','$LC_parent','$LC_child'";

    // SQL query
    db_insert($LC_table, $LC_SQL_VALUES);

    return;
}

?>
