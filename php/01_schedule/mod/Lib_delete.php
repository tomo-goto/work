<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/

require_once(dirname(__FILE__) . '/../common/DB2.php');
require_once(dirname(__FILE__) . '/../common/DB_gen.php');

if($_POST['submit']){
    // switch by tag
    switch($_POST['del_tag']){
        case 'del_parent':
        delete_parent($_POST);
        break;
        case 'del_child':
        delete_child($_POST);
        break;
        case 'del_daily':
        delete_daily($_POST);
        break;
        case 'del_special':
        delete_special($_POST);
        break;
        case 'del_littleimp':
        delete_little_impression($_POST);
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
function execute_delete(){

    // switch by tag
    switch($_POST['del_tag']){
        case 'del_parent':
        delete_parent($_POST);
        break;
        case 'del_child':
        delete_child($_POST);
        break;
        case 'del_daily':
        delete_daily($_POST);
        break;
        case 'del_special':
        delete_special($_POST);
        break;
        case 'del_littleimp':
        delete_little_impression($_POST);
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
function delete_parent($data){

    // set Data
    $LC_parent = $data['del_parent'];

    if( empty($LC_parent) ){
        // ERROR
    }

    // Set SQL key
    $LC_table = 'p_task';

    // Set SQL where
    $LC_array_where = array( 'big_task' => array( 'ope'  => '=',
                                                  'data' => "'$LC_parent'")
                           );

    // SQL query
    db_delete($LC_table, $LC_array_where);

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function delete_child($data){

    // set Data
    $LC_parent = $data['del_parent'];
    $LC_child  = $data['del_child'];

    if( empty($LC_parent) || empty($LC_child) ){
        // ERROR
    }

    // Set SQL key
    $LC_table = 'c_task';

    // Set SQL where
    $LC_array_where = array( 'big_task'    => array( 'ope'  => '=',
                                                     'data' => "'$LC_parent'"),
                             'little_task' => array( 'ope'  => '=',
                                                     'data' => "'$LC_child'")
                           );

    // SQL query
    db_delete($LC_table, $LC_array_where);

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function delete_daily($data){

    // set Data
    $LC_parent = $data['del_parent'];
    $LC_child  = $data['del_child'];
    $LC_todo   = $data['del_todo'];

    if( empty($LC_parent) || empty($LC_child) || empty($LC_todo) ){
        // ERROR
    }

    // Set SQL key
    $LC_table = 'todo_daily';

    // Set SQL where
    $LC_array_where = array( 'big_task'    => array( 'ope'  => '=',
                                                     'data' => "'$LC_parent'"),
                             'little_task' => array( 'ope'  => '=',
                                                     'data' => "'$LC_child'"),
                             'todo_name'   => array( 'ope'  => '=',
                                                     'data' => "'$LC_todo'")
                           );

    // SQL query
    db_delete($LC_table, $LC_array_where);

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function delete_special($data){

    // set Data
    $LC_parent = $data['del_parent'];
    $LC_child  = $data['del_child'];
    $LC_todo   = $data['del_todo'];

    if( empty($LC_parent) || empty($LC_child) || empty($LC_todo) ){
        // ERROR
    }

    // Set SQL key
    $LC_table = 'todo_special';

    // Set SQL where
    $LC_array_where = array( 'big_task'    => array( 'ope'  => '=',
                                                     'data' => "'$LC_parent'"),
                             'little_task' => array( 'ope'  => '=',
                                                     'data' => "'$LC_child'"),
                             'todo_name'   => array( 'ope'  => '=',
                                                     'data' => "'$LC_todo'")
                           );

    // SQL query
    db_delete($LC_table, $LC_array_where);

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function delete_little_impression($data){

    // set Data
    $LC_parent = $data['del_parent'];
    $LC_child  = $data['del_child'];
    $LC_title  = $data['del_title'];

    if( empty($LC_parent) || empty($LC_child) || empty($LC_title) ){
        // ERROR
    }

    // Set SQL key
    $LC_table = 'little_impression';

    // Set SQL where
    $LC_array_where = array( 'big_task'               => array( 'ope'  => '=',
                                                                'data' => "'$LC_parent'"),
                             'little_task'            => array( 'ope'  => '=',
                                                                'data' => "'$LC_child'"),
                             'little_impression_name' => array( 'ope'  => '=',
                                                                'data' => "'$LC_title'")
                           );

    // SQL query
    db_delete($LC_table, $LC_array_where);

    return;
}

?>
