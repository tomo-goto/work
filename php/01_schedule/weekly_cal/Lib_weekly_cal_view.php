<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/

require_once(dirname(__FILE__) . '/../common/DB.php');
require_once(dirname(__FILE__) . '/Lib_weekly_cal_com.php');

//++++++++++++++++++++++++ HEAD +++++++++++++++++++++++++++++++++++++++++++

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN1 : 20XX/XX/XX
          OUT1 :
          RETURN : (void)
**************************************************************************/
function view_weekly_cal_head($key_date){

    // DateTime
    $LC_datetime = new DateTime();

    // parse key_date to "Year" , "Month" and "Day"
    list($LC_year, $LC_month, $LC_day) = explode("-", $key_date);

    // setDate(Y, M, D) , setTime(h, m, s)
    $LC_datetime->setDate($LC_year, $LC_month, $LC_day)->setTime(0, 0, 0);

    // class name
    $LC_class_head = 'head';
    $LC_class_side_head = 'side_head';

    echo "<div class=\"" . $LC_class_head . "\">" . "\n";
    echo "<div class=\"" . $LC_class_side_head . "\"></div>" . "\n";

    view_weekly_cal_top_head($LC_datetime);

    echo "</div>" . "\n"; # end of head
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN1 :
          OUT1 :
          RETURN : (void)
**************************************************************************/
function view_weekly_cal_top_head($datetime){

    $LC_weeks_table = array('SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT');

    // class name
    $LC_class_top               = 'top';
    $LC_class_top_flagment      = 'top_flagment';
    $LC_class_top_flagment_tiny = 'top_flagment_tiny';

    for($FOR=0 ; $FOR < 7 ; $FOR++){

        // Data
        $LC_date  = $datetime->format('Y/m/d');
        $LC_tmp   = date('w', $datetime->getTimestamp());
        $LC_weeks = $LC_weeks_table[$LC_tmp];
    
        // html
        $LC_html = <<<EOF
    <div class="$LC_class_top">
        <div class="$LC_class_top_flagment">$LC_date</div>
        <div class="$LC_class_top_flagment">$LC_weeks</div>
        <div class="$LC_class_top_flagment_tiny">D</div>
        <div class="$LC_class_top_flagment_tiny">S</div>
    </div>
EOF;
echo $LC_html . "\n";
    
        $datetime->modify('+1 day');
    }

    return;
}

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN1 :
          OUT1 :
          RETURN : (void)
**************************************************************************/
function view_weekly_cal_table_side(){

    $LC_datetime = new DateTime('1970-1-1');

    // class name
    $LC_class_table_side = 'table_side';
    $LC_class_clock      = 'clock';

    echo "<div class=\"" . $LC_class_table_side . "\">" . "\n";

    for($FOR=0 ; $FOR < 48 ; $FOR++){

        // Data
        $LC_time = $LC_datetime->format('H:i');

        // html
        $LC_html = <<<EOF
    <div class="$LC_class_clock">$LC_time</div>
EOF;
echo $LC_html . "\n";

        $LC_datetime->modify('+30 minute');
    }

    echo "</div>" . "\n";

    return;
}

//+++++++++++++++++++++++++ CONTENT +++++++++++++++++++++++++++++++++++++++

/**************************************************************************
FUNCTION_NAME : view_weekly_todo_blanks
DISCRIPTION   : 
          IN1 :
          INOUT1 :
          RETURN :
**************************************************************************/
function view_weekly_todo_blanks($span){

    // class name
    $LC_class_blank = 'row blank';

    for($FOR=0 ; $FOR < $span ; $FOR++){

        // html
        $LC_html = <<<EOF
        <div class="$LC_class_blank">BL</div>
EOF;
echo $LC_html . "\n";
    }

    return;
}

/**************************************************************************
FUNCTION_NAME : view_weekly_todo_blanks
DISCRIPTION   : 
          IN1 :
          INOUT1 :
          RETURN :
**************************************************************************/
function view_weekly_todo($array_todo, $col_term, $col_todo_name, $date, $class_todo){

    // column names
    $LC_col_term      = $col_term;
    $LC_col_todo_name = $col_todo_name;

    // set baseline
    $LC_absolute_start = $date . " 0:00:00";
    $LC_absolute_end   = $date . " 24:00:00";

    // init for loop
    $LC_previous_date = $date . " 0:00:00";
    $LC_final_date    = $date . " 24:00:00";

    // class name
    $LC_class_todo = $class_todo;

    foreach($array_todo as $FE_row){

        // parse term
        list($LC_start_date, $LC_end_date) = explode(",", trim($FE_row[$LC_col_term],"()"));
        $LC_start_date = trim($LC_start_date, "\"");
        $LC_end_date   = trim($LC_end_date, "\"");

        // check border(start)
	if(strtotime($LC_start_date) < strtotime($LC_absolute_start)){
	    $LC_start_date = $LC_absolute_start;
	}

        // check border(end)
	if(strtotime($LC_absolute_end) < strtotime($LC_end_date)){
	    $LC_end_date = $LC_absolute_end;
	}

        // todo_end(prev) - todo_start
	$LC_span = calculate_todo_span($LC_previous_date, $LC_start_date);

        // if 0, wont dump any
	view_weekly_todo_blanks($LC_span);

        // todo_start - todo_end
	$LC_span = calculate_todo_span($LC_start_date, $LC_end_date);

        // Data
	$LC_todo_name = $FE_row[$LC_col_todo_name];
	$LC_height    = $LC_span * 24;

        // html
        $LC_html = <<<EOF
	<div class="$LC_class_todo" style="height: ${LC_height}px;">$LC_todo_name</div>
EOF;
echo $LC_html . "\n";

	$LC_previous_date = $LC_end_date;
    }

    // todo_end(prev) - todo_final
    $LC_span = calculate_todo_span($LC_previous_date, $LC_final_date);

    // if 0, wont dump any
    view_weekly_todo_blanks($LC_span);

    return;
}

/**************************************************************************
FUNCTION_NAME : view_weekly_todo_blanks
DISCRIPTION   : 
          IN1 :
          INOUT1 :
          RETURN :
**************************************************************************/
function view_weekly_todo_flagment($od_type, $date){

    switch($od_type){
        case 'daily':

        // Set SQL key
        $LC_table      = "todo_daily_time";
        // class name
        $LC_class_todo = 'daily';

        break;
        case 'special':

        // Set SQL key
        $LC_table      = "todo_special";
        // class name
        $LC_class_todo = 'special';

        break;
    }

    // Set SQL key(common)
    $LC_col_todo_name = "todo_name";
    $LC_col_term      = "period";
    $LC_range         = "'(" . $date . " 00:00:00," . $date . " 24:00:00)'::tsrange";

    // Set array
    $LC_array_where = array( $LC_col_term => array( 'ope'  => ' && ',
                                                    'data' => $LC_range)
                           );

    // SQL query
    select_all_with_WHERE($LC_array_todo, $LC_table, $LC_array_where);

    // "SQL result", "column name of term", "column name of todo_name", "key date", "class name"
    view_weekly_todo($LC_array_todo, $LC_col_term, $LC_col_todo_name, $date, $LC_class_todo);

    return;
}

/**************************************************************************
FUNCTION_NAME : view_weekly_todo_blanks
DISCRIPTION   : 
          IN1 :
          INOUT1 :
          RETURN :
**************************************************************************/
function view_weekly_todo_day($date){

    // class name
    $LC_class_data_flagment    = 'data_flagment';
    $LC_class_daily_flagment   = 'daily_flagment';
    $LC_class_special_flagment = 'special_flagment';

    // html_before
    $LC_html = <<<EOF
    <div class="$LC_class_data_flagment">
EOF;
echo $LC_html . "\n";

    // html_daily
    echo "<div class=\"" . $LC_class_daily_flagment . "\">" . "\n"; 

        view_weekly_todo_flagment('daily', $date);

    echo "</div>" . "\n"; # end of daily_flagment

    // html_special
    echo "<div class=\"" . $LC_class_special_flagment . "\">" . "\n"; 

        view_weekly_todo_flagment('special', $date);

    echo "</div>" . "\n"; # end of special_flagment

    // html_after
    $LC_html = <<<EOF
    </div>
EOF;
echo $LC_html . "\n";

    return;
}

/**************************************************************************
FUNCTION_NAME : view_weekly_todo_blanks
DISCRIPTION   : 
          IN1 :
          INOUT1 :
          RETURN :
**************************************************************************/
function view_weekly_todo_week($date, $od_mode){

    $LC_start_date = new DateTime($date);
    $LC_end_date   = new DateTime($date);

    //calculate_start_and_end_date($LC_start_date->getTimestamp(), 'dynamic', $LC_start_date, $LC_end_date);
    calculate_start_and_end_date($LC_start_date->getTimestamp(), $od_mode, $LC_start_date, $LC_end_date);

    // view head
    view_weekly_cal_head($LC_start_date->format('Y-m-d'));

    view_weekly_cal_table_side();

    // view content
    while($LC_start_date <= $LC_end_date){

        view_weekly_todo_day($LC_start_date->format('Y-m-d'));

        $LC_start_date->modify('+1 day');
    }

    return;
}

?>
