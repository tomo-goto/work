<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/

require_once(dirname(__FILE__) . '/../common/DB.php');
require_once(dirname(__FILE__) . '/Lib_process_com.php');

/************************** head ******************************************

/**************************************************************************
FUNCTION_NAME : view_process_head
DISCRIPTION   : 
          IN1 : 
          OUT : (int)
**************************************************************************/
function view_process_head(){

    // class name
    $LC_class_progress_head = 'progress_head';
    $LC_class_parent_head   = 'parent_head';
    $LC_class_children_head = 'children_head';
    $LC_class_parcent       = 'parcent';

    // html
    $LC_html = <<<EOF
        <div class="$LC_class_progress_head">
            <div class="$LC_class_parent_head">parent</div>
            <div class="$LC_class_children_head">children</div>
            <div class="$LC_class_parcent">0</div>
            <div class="$LC_class_parcent">10</div>
            <div class="$LC_class_parcent">20</div>
            <div class="$LC_class_parcent">30</div>
            <div class="$LC_class_parcent">40</div>
            <div class="$LC_class_parcent">50</div>
            <div class="$LC_class_parcent">60</div>
            <div class="$LC_class_parcent">70</div>
            <div class="$LC_class_parcent">80</div>
            <div class="$LC_class_parcent">90</div>
            <div class="$LC_class_parcent">100</div>
        </div>
EOF;
echo $LC_html . "\n";

    return;
}

/************************** content ***************************************

/**************************************************************************
FUNCTION_NAME : view_process_children
DISCRIPTION   : 
          IN1 : array_children -> SQL result of "select * from c_task"
          IN1 : array_daily    -> SQL result of "select * from todo_daily"
          IN1 : array_special  -> SQL result of "select * from todo_special"
          IN2 : parent         -> key
          OUT : (void)
**************************************************************************/
function view_process_children($array_children, $array_daily, $array_special, $parent){

    $LC_p_rate = 0;

    // class name
    $LC_class_children   = 'children';
    $LC_class_child      = 'child';
    $LC_class_child_name = 'child_name';
    $LC_class_process    = 'progress';

    echo "<div class=\"" . $LC_class_children . "\">" . "\n";

    foreach($array_children as $FE_row){

        if($FE_row['big_task'] == $parent){

            // Data
            $LC_child  = $FE_row['little_task'];
	    $LC_p_rate = calculate_child_process_rate($array_daily, $array_special, $parent, $FE_row['little_task']);

            // html
            $LC_html = <<<EOF
        <div class="$LC_class_child">
            <div class="$LC_class_child_name">$LC_child</div>
            <div class="$LC_class_process">$LC_p_rate</div>
        </div>
EOF;
echo $LC_html . "\n";
        }
    }

    echo "</div>" . "\n"; # end of children

    return;
}

/**************************************************************************
FUNCTION_NAME : view_process
DISCRIPTION   :
          IN  :
          OUT : (void)
**************************************************************************/
function view_process(){

    // class name
    $LC_class_parent      = 'parent';
    $LC_class_parent_name = 'parent_name';

    // SQL query
    select_all($LC_array_parent  , 'p_task');
    select_all($LC_array_children, 'c_task');
    select_all($LC_array_daily   , 'todo_daily');
    select_all($LC_array_special , 'todo_special');

    foreach($LC_array_parent as $FE_row){

        // Data
        $LC_parent = $FE_row['big_task'];

        // html
        $LC_html = <<<EOF
    <div class="$LC_class_parent"><span class="$LC_class_parent_name">$LC_parent</span>
EOF;
echo $LC_html . "\n";

        view_process_children($LC_array_children, $LC_array_daily, $LC_array_special, $LC_parent);

        // html
        $LC_html = <<<EOF
    </div>
EOF;
echo $LC_html . "\n";
    }

    return;
}

?>
