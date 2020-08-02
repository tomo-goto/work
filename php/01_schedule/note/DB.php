<?php

require_once(dirname(__FILE__) . '/DB_gen.php');

    // credentials
    $GL_dsn      = 'pgsql:dbname=note host=localhost port=5432';
    $GL_user     = 'postgres';
    $GL_password = '';

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT :
**************************************************************************/
function select_all(&$REF_sql_result, $key_table_name){

    global $GL_dsn;
    global $GL_user;
    global $GL_password;

    $LC_pdo = new PDO($GL_dsn, $GL_user, $GL_password);

    // create SQL
    $LC_SQL = "SELECT * FROM " . $key_table_name;

    // return SQL result
    $LC_ret = $LC_pdo->query($LC_SQL);
    $REF_sql_result = $LC_ret->fetchAll();

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT :
**************************************************************************/
function select_all_with_WHERE(&$REF_sql_result, $key_table_name, $array_where){

    global $GL_dsn;
    global $GL_user;
    global $GL_password;

    $LC_pdo = new PDO($GL_dsn, $GL_user, $GL_password);

    // create SQL
    $LC_SQL_WHERE = SQLGEN_where($array_where);
    $LC_SQL = "SELECT * FROM  $key_table_name $LC_SQL_WHERE";

try {
    $LC_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $LC_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // return SQL result
    $LC_ret = $LC_pdo->query($LC_SQL);
    $REF_sql_result = $LC_ret->fetchAll();
}
catch(Exception $e) {
    var_dump($e->getMessage());
}


    return;
}

?>
