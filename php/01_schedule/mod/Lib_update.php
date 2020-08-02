<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/

require_once(dirname(__FILE__) . '/../common/DB2.php');

if($_POST['submit']){
    // switch by tag
    switch($_POST['upd_tag']){
        case 'upd_parent':
        update_parent($_POST);
        break;
        case 'upd_child':
        update_child($_POST);
        break;
        case 'upd_daily':
        update_daily($_POST);
        break;
        case 'upd_special':
        update_special($_POST);
        break;
        case 'upd_littleimp':
        update_little_impression($_POST);
        break;
    }

    $uri = $_SERVER['HTTP_REFERER'];
    header("Location: ".$uri, true, 303);
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function execute_update(){

    // switch by tag
    switch($_POST['upd_tag']){
        case 'upd_parent':
        update_parent($_POST);
        break;
        case 'upd_child':
        update_child($_POST);
        break;
        case 'upd_daily':
        update_daily($_POST);
        break;
        case 'upd_special':
        update_special($_POST);
        break;
        case 'upd_littleimp':
        update_little_impression($_POST);
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
function update_parent($data){

    // Set Data
    $LC_parent     = $data['upd_parent'];
    $LC_new_parent = $data['upd_new_parent'];

    // parameter check
    if( empty($LC_parent) || empty($LC_new_parent) ){
        // ERROR
    }

    // Set SQL key
    $LC_table = 'p_task';

    // Set array
    $LC_array_set   = array( 'big_task' => "'$LC_new_parent'" );
    $LC_array_where = array( 'big_task' => array( 'ope'  => '=',
                                                  'data' => "'$LC_parent'")
                           );

    // SQL query
    db_update($LC_table, $LC_array_set, $LC_array_where);

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function update_child($data){

    // set Data
    $LC_parent = $data['upd_parent'];
    $LC_child  = $data['upd_child'];
    $LC_new_child  = $data['upd_new_child'];
    $LC_new_start  = $data['upd_new_start'];
    $LC_new_end    = $data['upd_new_end'];
    $LC_new_goal   = $data['upd_new_goal'];
    $LC_new_comp   = $data['upd_new_comp'];

    if( empty($LC_parent) || empty($LC_child) ){
        // ERROR
    }

    // Set SQL key
    $LC_table = 'c_task';

    // Set array
    $LC_array_set   = array();
    $LC_array_where = array( 'big_task'    => array( 'ope'  => '=',
                                                     'data' => "'$LC_parent'" ),
                             'little_task' => array( 'ope'  => '=',
                                                     'data' => "'$LC_child'" )
                           );

    if( !empty($LC_new_child) ){
        $LC_array_set += array( 'little_task'=>"'$LC_new_child'" );
    }

    if( !empty($LC_new_start) && !empty($LC_new_end) ){
        $LC_array_set += array( 'term'=>"'[$LC_new_start,$LC_new_end)'::daterange" );
    }

    if( !empty($LC_new_goal) ){
        $LC_array_set += array( 'goal'=>"'$LC_new_goal'" );
    }

    if( !empty($LC_new_comp) ){
        $LC_array_set += array( 'impression_after_completion'=>"'$LC_new_comp'" );
    }

    // SQL query
    db_update($LC_table, $LC_array_set, $LC_array_where);

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function update_daily($data){

    // set Data
    $LC_parent = $data['upd_parent'];
    $LC_child  = $data['upd_child'];
    $LC_todo   = $data['upd_todo'];
    $LC_new_todo   = $data['upd_new_todo'];
    $LC_new_obs    = $data['upd_new_obs'];
    $LC_new_status = $data['upd_new_status'];
    $LC_new_pri    = $data['upd_new_pri'];
    $LC_new_todo_s = $data['upd_new_todo_start'];
    $LC_new_todo_e = $data['upd_new_todo_end'];

    $LC_new_mon_s  = $data['upd_new_mon_start'];
    $LC_new_mon_e  = $data['upd_new_mon_end'];
    $LC_new_tue_s  = $data['upd_new_tue_start'];
    $LC_new_tue_e  = $data['upd_new_tue_end'];
    $LC_new_wed_s  = $data['upd_new_wed_start'];
    $LC_new_wed_e  = $data['upd_new_wed_end'];
    $LC_new_thu_s  = $data['upd_new_thu_start'];
    $LC_new_thu_e  = $data['upd_new_thu_end'];
    $LC_new_fri_s  = $data['upd_new_fri_start'];
    $LC_new_fri_e  = $data['upd_new_fri_end'];
    $LC_new_sat_s  = $data['upd_new_sat_start'];
    $LC_new_sat_e  = $data['upd_new_sat_end'];
    $LC_new_sun_s  = $data['upd_new_sun_start'];
    $LC_new_sun_e  = $data['upd_new_sun_end'];

    if( empty($LC_parent) || empty($LC_child) || empty($LC_todo) ){
        // ERROR
    }

    // Set SQL key
    $LC_table = 'todo_daily';

    // Set array
    $LC_array_set   = array();
    $LC_array_where = array( 'big_task'    => array( 'ope'  => '=',
                                                     'data' => "'$LC_parent'"),
                             'little_task' => array( 'ope'  => '=',
                                                     'data' => "'$LC_child'"),
                             'todo_name'   => array( 'ope'  => '=',
                                                     'data' => "'$LC_todo'" )
                           );

    if( !empty($LC_new_todo) ){
        $LC_array_set += array( 'todo_name'=>"'$LC_new_todo'" );
    }

    if( !empty($LC_new_obs) ){
        $LC_array_set += array( 'obstacle'=>"'$LC_new_obs'" );
    }

    if( !empty($LC_new_status) ){
        $LC_array_set += array( 'status'=>"'$LC_new_status'" );
    }

    if( !empty($LC_new_pri) ){
        $LC_array_set += array( 'priority'=>"'$LC_new_pri'" );
    }

    if( !empty($LC_new_todo_s) && !empty($LC_new_todo_e) ){
        $LC_array_set += array( 'period'=>"'[$LC_new_todo_s,$LC_new_todo_e)'::daterange" );
    }

    // Monday
    if( !empty($LC_new_mon_s) && !empty($LC_new_mon_e) ){
        $LC_array_set += array( 'mon'=>"'(1970-1-1 $LC_new_mon_s,1970-1-1 $LC_new_mon_e)'::tsrange" );
    }

    // Tuesday
    if( !empty($LC_new_tue_s) && !empty($LC_new_tue_e) ){
        $LC_array_set += array( 'tue'=>"'(1970-1-1 $LC_new_tue_s,1970-1-1 $LC_new_tue_e)'::tsrange" );
    }

    // Wednesday
    if( !empty($LC_new_wed_s) && !empty($LC_new_wed_e) ){
        $LC_array_set += array( 'wed'=>"'(1970-1-1 $LC_new_wed_s,1970-1-1 $LC_new_wed_e)'::tsrange" );
    }

    // Thursday
    if( !empty($LC_new_thu_s) && !empty($LC_new_thu_e) ){
        $LC_array_set += array( 'thu'=>"'(1970-1-1 $LC_new_thu_s,1970-1-1 $LC_new_thu_e)'::tsrange" );
    }

    // Friday
    if( !empty($LC_new_fri_s) && !empty($LC_new_fri_e) ){
        $LC_array_set += array( 'fri'=>"'(1970-1-1 $LC_new_fri_s,1970-1-1 $LC_new_fri_e)'::tsrange" );
    }

    // Saturday
    if( !empty($LC_new_sat_s) && !empty($LC_new_sat_e) ){
        $LC_array_set += array( 'sat'=>"'(1970-1-1 $LC_new_sat_s,1970-1-1 $LC_new_sat_e)'::tsrange" );
    }

    // Sunday
    if( !empty($LC_new_sun_s) && !empty($LC_new_sun_e) ){
        $LC_array_set += array( 'sun'=>"'(1970-1-1 $LC_new_sun_s,1970-1-1 $LC_new_sun_e)'::tsrange" );
    }

    // SQL query
    db_update($LC_table, $LC_array_set, $LC_array_where);

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function update_special($data){

    // set Data
    $LC_parent = $data['upd_parent'];
    $LC_child  = $data['upd_child'];
    $LC_todo   = $data['upd_todo'];
    $LC_new_todo   = $data['upd_new_todo'];
    $LC_new_obs    = $data['upd_new_obs'];
    $LC_new_status = $data['upd_new_status'];
    $LC_new_pri    = $data['upd_new_pri'];
    $LC_new_start  = $data['upd_new_todo_start_ts'];
    $LC_new_end    = $data['upd_new_todo_end_ts'];

    if( empty($LC_parent) || empty($LC_child) || empty($LC_todo) ){
        // ERROR
    }

   // Set SQL key
    $LC_table = 'todo_special';

    // Set array
    $LC_array_set   = array();
    $LC_array_where = array( 'big_task'    => array( 'ope'  => '=',
                                                     'data' => "'$LC_parent'"),
                             'little_task' => array( 'ope'  => '=',
                                                     'data' => "'$LC_child'"),
                             'todo_name'   => array( 'ope'  => '=',
                                                     'data' => "'$LC_todo'")
                           );

    if( !empty($LC_new_todo) ){
        $LC_array_set += array( 'todo_name'=>"'$LC_new_todo'" );
    }

    if( !empty($LC_new_obs) ){
        $LC_array_set += array( 'obstacle'=>"'$LC_new_obs'" );
    }

    if( !empty($LC_new_status) ){
        $LC_array_set += array( 'status'=>"'$LC_new_status'" );
    }

    if( !empty($LC_new_pri) ){
        $LC_array_set += array( 'priority'=>"'$LC_new_pri'" );
    }

    if( !empty($LC_new_start) && !empty($LC_new_end) ){
        $LC_new_start = str_replace('T',' ',$LC_new_start);
        $LC_new_end   = str_replace('T',' ',$LC_new_end);

        $LC_array_set += array( 'period'=>"'($LC_new_start,$LC_new_end)'::tsrange" );
    }

    // SQL query
    db_update($LC_table, $LC_array_set, $LC_array_where);

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function update_little_impression($data){

    // set Data
    $LC_parent = $data['upd_parent'];
    $LC_child  = $data['upd_child'];
    $LC_title  = $data['upd_title'];
    $LC_new_title  = $data['upd_new_title'];
    $LC_new_litimp = $data['upd_new_litimp'];

    if( empty($LC_parent) || empty($LC_child) || empty($LC_title) ){
        // ERROR
    }

    // Set SQL key
    $LC_table = 'little_impression';

    // Set array
    $LC_array_set   = array();
    $LC_array_where = array( 'big_task'               => array( 'ope'  => '=',
                                                                'data' => "'$LC_parent'"),
                             'little_task'            => array( 'ope'  => '=',
                                                                'data' => "'$LC_child'"),
                             'little_impression_name' => array( 'ope'  => '=',
                                                                'data' => "'$LC_title'")
                           );

    if( !empty($LC_new_title) ){
        $LC_array_set += array( 'little_impression_name'=>"'$LC_new_title'" );
    }

    if( !empty($LC_new_litimp) ){
        $LC_array_set += array( 'sentence'=>"'$LC_new_litimp'" );
    }

    // SQL query
    db_update($LC_table, $LC_array_set, $LC_array_where);

    return;
}

?>
