<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/

require_once(dirname(__FILE__) . '/DB.php');

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN1 :
          OUT :
**************************************************************************/
function view_menu(){

    // table name
    $LC_table = 'category';

    // DB read
    select_all($LC_array_menu, $LC_table);

    // indent
    $LC_indent3 = '            ';
    $LC_indent4 = '                ';

    // html
    echo "$LC_indent3<ul>\n";
    foreach($LC_array_menu as $FE_row){
        echo "$LC_indent4<li><a href=\"note.php?category=${FE_row['category_id']}\">${FE_row['category_name']}</a></li>\n";
    }
    echo "$LC_indent3</ul>\n";

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN1 :
          OUT :
**************************************************************************/
function view_title($category){

    // table name
    $LC_table = 'title';

    // Set array
    $LC_array_where = array( 'category_id' => array( 'ope'  => "=",
                                                     'data' => "'$category'" )
                           );

    // DB read
    select_all_with_WHERE($LC_array_title, $LC_table, $LC_array_where);

    // indent
    $LC_indent3 = '            ';
    $LC_indent4 = '                ';

    // html
    echo "$LC_indent3<ul>\n";
    foreach($LC_array_title as $FE_row){
        echo "$LC_indent4<li><a href=\"note.php?category=$category&title=${FE_row['title_id']}\">${FE_row['title_name']}</a></li>\n";
    }
    echo "$LC_indent3</ul>\n";

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN1 :
          OUT :
**************************************************************************/
function view_article($category, $title){

    // table name
    $LC_table = 'title';

    // Set array
    $LC_array_where = array( 'category_id' => array( 'ope'  => "=",
                                                     'data' => "'$category'"),
                             'title_id'    => array( 'ope'  => "=",
                                                     'data' => "'$title'")
                           );

    // DB read
    select_all_with_WHERE($LC_array_title, $LC_table, $LC_array_where);

    echo $LC_array_title[0]['article'] . "\n";

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN1 :
          OUT :
**************************************************************************/
function view_navi($category, $title){

    // table name
    $LC_table = 'navi';

    // Set array
    $LC_array_where = array( 'category_id' => array( 'ope'  => "=",
                                                     'data' => "'$category'"),
                             'title_id'    => array( 'ope'  => "=",
                                                     'data' => "'$title'")
                           );

    // DB read
    select_all_with_WHERE($LC_array_navi, $LC_table, $LC_array_where);

    // indent
    $LC_indent3 = '            ';
    $LC_indent4 = '                ';

    // html
    echo "$LC_indent3<ul>\n";
    foreach($LC_array_navi as $FE_row){
        echo "$LC_indent4<li><a href=\"#LCREF_${FE_row['navi_id']}\">${FE_row['navi_name']}</a></li>\n";
    }
    echo "$LC_indent3</ul>\n";

    return;
}

?>
