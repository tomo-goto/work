<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/

require_once(dirname(__FILE__) . '/../common/DB.php');

//++++++++++++++++++++++++  head  +++++++++++++++++++++++++++++++++++++++++

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN1 :
          OUT1 :
          RETURN : (void)
**************************************************************************/
function view_milestone_head_flagment($start_date, $end_date){

    // pointer DateTime
    $LC_pointer_datetime = new DateTime($start_date);

    // class name
    $LC_class_milestone_head = 'milestone_head';
    $LC_class_month          = 'month';
    $LC_class_day            = 'day';

    // memorize previous month
    $LC_pre_month = $LC_pointer_datetime->format('m');

    echo "<div class=\"" . $LC_class_milestone_head . "\">" . "\n";

    while($LC_pointer_datetime->getTimestamp() <= strtotime($end_date)){

        // Data
	$LC_month = $LC_pointer_datetime->format('m');

        // html before
        $LC_html = <<<EOF
    <div class="$LC_class_month">$LC_month<br>
EOF;
echo $LC_html . "\n";

        while(strcmp($LC_pre_month, $LC_pointer_datetime->format('m')) == 0){

            // if pointer exceeds end_date, finish loop
	    if(strtotime($end_date) < $LC_pointer_datetime->getTimestamp()){
	        break;
	    }
	    
	    // Data
	    $LC_day = $LC_pointer_datetime->format('d');

            // html day
	    $LC_html = <<<EOF
        <div class="$LC_class_day">$LC_day</div>
EOF;
echo $LC_html . "\n";
	    
            $LC_pointer_datetime->modify('+1 day');
	}

	// html after
	$LC_html = <<<EOF
    </div>
EOF;
echo $LC_html . "\n";

        // update previous month
	$LC_pre_month = $LC_pointer_datetime->format('m');
    }

    echo "</div>" . "\n"; # end of milestone_head

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN1 :
          OUT1 :
          RETURN : (void)
**************************************************************************/
function view_milestone_head($start_date, $end_date){

    // class name
    $LC_class_head          = 'head';
    $LC_class_parent_head   = 'task_head';
    $LC_class_children_head = 'task_head';

    // html before
    $LC_html = <<<EOF
<div class="$LC_class_head">
<div class="$LC_class_parent_head">parent</div>
<div class="$LC_class_children_head">children</div>
EOF;
echo $LC_html . "\n";

    view_milestone_head_flagment($start_date, $end_date);

    // html after
    $LC_html = <<<EOF
</div>
EOF;
echo $LC_html . "\n";

    return;
}

//++++++++++++++++++++++++  content  ++++++++++++++++++++++++++++++++++++++

/**************************************************************************
FUNCTION_NAME : view_milestone_schedule
DISCRIPTION   : 
          IN1 : start_date       -> start date of whole table
          IN2 : end_date         -> end   date of whole table
          IN3 : child_start_date -> start date of c_task
          IN4 : child_end_date   -> end   date of c_task
          IN5 : od_class         -> order of what class to apply
          OUT : (void)
**************************************************************************/
function view_milestone_child($od_class, $start_datetime, $end_datetime, $child_start_date, $child_end_date){

    // pointer DateTime
    $LC_pointer_datetime = new DateTime($start_datetime->format('Y-m-d'));

    // class name
    $LC_class_schedule = 'column schedule';

    // switch class for dayon
    switch($od_class){
        case 0:
	    $LC_class_dayon = 'dayon1';
            break;
	case 1:
	    $LC_class_dayon = 'dayon2';
	    break;
	case 2:
	    $LC_class_dayon = 'dayon3';
	    break;
    }

    echo "<div class=\"" . $LC_class_schedule . "\">" . "\n";

    while($LC_pointer_datetime <= $end_datetime){

        if(strtotime($child_start_date)         <= $LC_pointer_datetime->getTimestamp() &&
           $LC_pointer_datetime->getTimestamp() <= strtotime($child_end_date)){
            // is dayon
            $LC_class_day = 'column ' . $LC_class_dayon;
	}
	else{
            // is dayoff
            $LC_class_day = 'column dayoff';
	}

        // Data
        $LC_day_num = $LC_pointer_datetime->format('d');

        // html
        $LC_html = <<<EOF
        <div class="$LC_class_day">$LC_day_num</div>
EOF;
echo $LC_html . "\n";

        // increment day pointer
        $LC_pointer_datetime->modify('+1 day');
    }

    echo "</div>" . "\n"; #end of schedule

    return;
}

/**************************************************************************
FUNCTION_NAME : view_milestone_children
DISCRIPTION   : 
          IN1 : array_children -> SQL result of "select * from c_task"
          IN2 : key_parent     -> key
          IN3 : start_date     -> start date of whole table
          IN4 : end_date       -> end   date of whole table
          OUT : (void)
**************************************************************************/
function view_milestone_row($array_children, $key_parent, $start_datetime, $end_datetime){

    $LC_cnt = 0;

    // Set SQL key
    $LC_col_parent      = "big_task";
    $LC_col_child       = "little_task";
    $LC_col_child_start = "beginning_day";
    $LC_col_child_end   = "finishing_day";

    // class name
    $LC_class_children   = 'column children';
    $LC_class_child      = 'row child';
    $LC_class_child_name = 'column child_name';

    echo "<div class=\"" . $LC_class_children . "\">" . "\n";

    foreach($array_children as $FE_row){

        $LC_child_start_date = trim($FE_row[$LC_col_child_start],"\"");
        $LC_child_end_date   = trim($FE_row[$LC_col_child_end],"\"");

        if($FE_row[$LC_col_parent] == $key_parent){

	    echo "<div class=\"" . $LC_class_child ."\">" . "\n";
	    echo "    <div class=\"" . $LC_class_child_name ."\">" . $FE_row[$LC_col_child] . "</div>" . "\n";
	    view_milestone_child($LC_cnt, $start_datetime, $end_datetime, $LC_child_start_date, $LC_child_end_date);
	    echo "</div>" . "\n"; # end of child
        }

	$LC_cnt++;
	$LC_cnt %= 3;
    }

    echo "</div>" . "\n"; #end of children

    return;
}

/**************************************************************************
FUNCTION_NAME : view_milestone
DISCRIPTION   : 
          IN1 : array_parent   -> SQL result of "select * from p_task"
          IN2 : array_children -> SQL result of "select * from c_task"
          IN3 : start_date     -> start date of whole table
          IN4 : end_date       -> end   date of whole table
          OUT : (void)
**************************************************************************/
function view_milestone($start_date, $end_date){

    $LC_start_datetime = new DateTime($start_date);
    $LC_end_datetime   = new Datetime($end_date);

    // Set SQL key
    $LC_col_parent = "big_task";
    $LC_col_child  = "little_task";

    // class name
    $LC_class_parent = 'row parent';

    // SQL query
    select_all($LC_array_parent  , 'p_task');
    select_all($LC_array_children, 'c_task');

    foreach($LC_array_parent as $FE_row){

        echo "<div class=\"" . $LC_class_parent . "\">" . $FE_row[$LC_col_parent] . "\n";

        view_milestone_row($LC_array_children, $FE_row[$LC_col_parent], $LC_start_datetime, $LC_end_datetime);

	echo "</div>" . "\n"; # end of parent
    }

    return;
}

?>
