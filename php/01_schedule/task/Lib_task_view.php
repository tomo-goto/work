<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/

require_once(dirname(__FILE__) . '/../common/DB.php');
require_once(dirname(__FILE__) . '/../mod/Lib_view_insert.php');
require_once(dirname(__FILE__) . '/../mod/Lib_view_update.php');
require_once(dirname(__FILE__) . '/../mod/Lib_view_delete.php');

/**************************************************************************
FUNCTION_NAME : view_task_todo_d
DISCRIPTION   : List daily to do
          IN1 : array_todo  -> SQL result of "select * from todo_daily"
          IN2 : parent      -> key
          IN3 : child       -> key
          OUT : (void)
**************************************************************************/
function view_task_todo_d($array_todo, $parent, $child){

    // class name
    $LC_class_todo          = 'row todo';
    $LC_class_todo_fragment = 'column todo_fragment';

    foreach($array_todo as $FE_row){
        if($FE_row['big_task'] == $parent && $FE_row['little_task'] == $child){

            // Data
            $LC_todo_name = $FE_row['todo_name'];
            $LC_obstacle  = $FE_row['obstacle'];
            $LC_status    = $FE_row['status'];
            $LC_priority  = $FE_row['priority'];

            // html
            $LC_html = <<<EOF
            <div class="$LC_class_todo">
                <div class="$LC_class_todo_fragment">$LC_todo_name</div>
                <div class="$LC_class_todo_fragment">$LC_obstacle</div>
                <div class="$LC_class_todo_fragment">$LC_status</div>
                <div class="$LC_class_todo_fragment">$LC_priority</div>
            </div>
EOF;
echo $LC_html . "\n";
        }
    }

    return;
}

/**************************************************************************
FUNCTION_NAME : view_task_todo_s
DISCRIPTION   : List special to do
          IN1 : array_todo  -> SQL result of "select * from special"
          IN2 : parent      -> key
          IN3 : child       -> key
          OUT : (void)
**************************************************************************/
function view_task_todo_s($array_todo, $parent, $child){

    // class name
    $LC_class_todo          = 'row todo';
    $LC_class_todo_fragment = 'column todo_fragment';

    foreach($array_todo as $FE_row){
        if($FE_row['big_task'] == $parent && $FE_row['little_task'] == $child){

            // Data
            $LC_todo_name = $FE_row['todo_name'];
            $LC_obstacle  = $FE_row['obstacle'];
            $LC_status    = $FE_row['status'];
            $LC_priority  = $FE_row['priority'];
            $LC_term      = $FE_row['term'];

            // html
            $LC_html = <<<EOF
            <div class="$LC_class_todo">
                <div class="$LC_class_todo_fragment">$LC_todo_name</div>
                <div class="$LC_class_todo_fragment">$LC_obstacle</div>
                <div class="$LC_class_todo_fragment">$LC_status</div>
                <div class="$LC_class_todo_fragment">$LC_priority</div>
<!--
                <div class="$LC_class_todo_fragment">$LC_term</div>
-->
            </div>
EOF;
echo $LC_html . "\n";
        }
    }

    return;
}

/**************************************************************************
FUNCTION_NAME : view_task_children
DISCRIPTION   : List children
          IN1 : array_children   -> SQL result of "select * from c_task"
          IN2 : array_daily      -> SQL result of "select * from todo_daily"
          IN3 : array_special    -> SQL result of "select * from todo_special"
          IN4 : array_little_imp -> SQL result of "select * from little_impression"
          IN5 : parent -> key
          IN6 : mode   -> can choose which to print ... todo_list / little_imp_list
          OUT : (void)
**************************************************************************/
function view_task_children($array_children, $array_daily, $array_special, $array_little_imp, $parent, $od_mode){

    // class name
    $LC_class_children   = 'children';
    $LC_class_child      = 'child';
    $LC_class_child_name = 'child_name';
    $LC_class_goal       = 'goal';
    $LC_class_child_term = 'child_term';
    $LC_class_impression = 'imp_aft_comp';
    $LC_class_time_spent = 'time_spent';
    $LC_class_todo_list  = 'todo_list';

    echo "<div class=\"" . $LC_class_children . "\">" ."\n";

    foreach($array_children as $FE_row){
        if($FE_row['big_task'] == $parent){

            echo "    <div class=\"" . $LC_class_child . "\">" ."\n";

            // Data
            $LC_child_name    = $FE_row['little_task'];
            $LC_goal          = $FE_row['goal'];
            $LC_beginning_day = $FE_row['beginning_day'];
            $LC_finishing_day = $FE_row['finishing_day'];
            $LC_impression    = $FE_row['imp_aft_comp'];
            $LC_elapsed_time  = $FE_row['elapsed_time'];

            // html
            $LC_html = <<<EOF
        <div class="$LC_class_child_name">$LC_child_name</div>
        <div class="$LC_class_goal">$LC_goal</div>
<!--
        <div class="$LC_class_child_term">$LC_beginning_day</div>
        <div class="$LC_class_child_term">$LC_finishing_day</div>
        <div class="$LC_class_impression">$LC_impression</div>
-->
        <div class="$LC_class_time_spent">$LC_elapsed_time</div>
EOF;
echo $LC_html . "\n";

            if($od_mode == 'TODO'){
                echo "        <div class=\"" . $LC_class_todo_list . "\">" . "\n";
          
                // List daily to do
                view_task_todo_d($array_daily  , $parent, $FE_row['little_task']);
          
                // List special to do
                view_task_todo_s($array_special, $parent, $FE_row['little_task']);

                echo "        </div>" . "\n"; # end of todo_list
            }
            else if($od_mode == 'IMP'){
                //T.B.D
            }

            echo "    </div>" . "\n"; # end of child
        }
    }

    echo "</div>" . "\n"; # end of children

    return;
}

/**************************************************************************
FUNCTION_NAME : view_task
DISCRIPTION   : List whole tasks
          IN1 : array_parent     -> SQL result of "select * from p_task"
          IN2 : array_children   -> SQL result of "select * from c_task"
          IN3 : array_daily      -> SQL result of "select * from todo_daily"
          IN4 : array_special    -> SQL result of "select * from todo_special"
          IN5 : array_little_imp -> SQL result of "select * from little_impression"
          OUT : (void)
**************************************************************************/
function view_task(){

    // class name
    $LC_class_parent = 'parent';

    // SQL query
    select_all($LC_array_parent  , 'p_task');
    select_all($LC_array_children, 'c_task');
    select_all($LC_array_daily   , 'todo_daily');
    select_all($LC_array_special , 'todo_special');

    //view_insert();
    //view_update();
    //view_delete();

    foreach($LC_array_parent as $FE_row){

        echo "<div class=\"" . $LC_class_parent . "\"><span style=\"width: 100px\">" . $FE_row['big_task'] . "</span>" . "\n";
        
        view_task_children($LC_array_children, $LC_array_daily, $LC_array_special, NULL, $FE_row['big_task'], 'TODO');

        echo "</div>" . "\n"; # end of parent
    }

    return;
}

?>
