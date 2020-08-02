<?php

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
function select_all(&$REF_sql_result, $key_table_name){

    global $GL_dsn;
    global $GL_user;
    global $GL_password;

    $LC_pdo = new PDO($GL_dsn, $GL_user, $GL_password);

    // create SQL
    $LC_SQL = "SELECT * FROM " . $key_table_name;

    // return SQL result
    $REF_sql_result = $LC_pdo->query($LC_SQL);

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT :
**************************************************************************/
function select_all_with_WHERE(&$REF_sql_result, $key_table_name, $SQL_where){

    global $GL_dsn;
    global $GL_user;
    global $GL_password;

    $LC_pdo = new PDO($GL_dsn, $GL_user, $GL_password);

    // create SQL
    $LC_SQL = "SELECT * FROM " . $key_table_name . " " . $SQL_where;

    // return SQL result
    $REF_sql_result = $LC_pdo->query($LC_SQL);

    return;
}

?>
