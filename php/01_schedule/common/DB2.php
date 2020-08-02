<?php

require_once(dirname(__FILE__) . '/DB_gen.php');

    // credentials
    $GL_dsn      = 'pgsql:dbname=postgres host=localhost port=5432';
    $GL_user     = 'postgres';
    $GL_password = '';

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT :
**************************************************************************/
function db_insert($key_table_name, $SQL_values){

    global $GL_dsn;
    global $GL_user;
    global $GL_password;

    $LC_pdo = new PDO($GL_dsn, $GL_user, $GL_password);

    // create SQL
    $LC_SQL = "INSERT INTO $key_table_name VALUES($SQL_values)";

    // return SQL result
    //$LC_ret = $LC_pdo->query($LC_SQL);
    echo "$LC_SQL\n";

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT :
**************************************************************************/
function db_update($key_table_name, $array_set, $array_where){

    global $GL_dsn;
    global $GL_user;
    global $GL_password;

    $LC_pdo = new PDO($GL_dsn, $GL_user, $GL_password);

    // create SQL
    $LC_SQL_SET   = SQLGEN_set($array_set);
    $LC_SQL_WHERE = SQLGEN_where($array_where);
    $LC_SQL = "UPDATE $key_table_name $LC_SQL_SET $LC_SQL_WHERE";

    // return SQL result
    //$LC_ret = $LC_pdo->query($LC_SQL);
    echo "$LC_SQL\n";

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT :
**************************************************************************/
function db_delete($key_table_name, $array_where){

    global $GL_dsn;
    global $GL_user;
    global $GL_password;

    $LC_pdo = new PDO($GL_dsn, $GL_user, $GL_password);

    // create SQL
    $LC_SQL_WHERE = SQLGEN_where($array_where);
    $LC_SQL = "DELETE FROM $key_table_name $LC_SQL_WHERE";

    // return SQL result
    //$LC_ret = $LC_pdo->query($LC_SQL);
    echo "$LC_SQL\n";

    return;
}

?>
