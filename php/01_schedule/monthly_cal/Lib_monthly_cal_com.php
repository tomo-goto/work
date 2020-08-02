<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/

require_once(dirname(__FILE__) . '/../common/DB.php');

/**************************************************************************
FUNCTION_NAME :view_monthly_cal 
DISCRIPTION   : 
          IN1 :
          OUT1 :
          RETURN : (void)
**************************************************************************/
function calculate_blanks_and_last_date($datetime, &$ref_blanks, &$ref_last_date){

    $LC_timestamp = $datetime->getTimestamp();

    // set last_date
    $ref_last_date = intval( $datetime->format('t') );

    // get weeks and
    // set blanks
    switch(date('w', $LC_timestamp)){
        case 0: //Sunday
	$ref_blanks = 6;
	break;
        case 1: //Monday
	$ref_blanks = 0;
	break;
        case 2: //Tuesday
	$ref_blanks = 1;
	break;
        case 3: //Wednesday
	$ref_blanks = 2;
	break;
        case 4: //Thursday
	$ref_blanks = 3;
	break;
        case 5: //Friday
	$ref_blanks = 4;
	break;
        case 6: //Saturday
	$ref_blanks = 5;
	break;
    }

    return;
}

/**************************************************************************
FUNCTION_NAME :view_monthly_cal 
DISCRIPTION   : 
          IN1 : key_date should be format like "YYYY-MM-DD"
          IN2 :
          OUT1 :
          RETURN : (void)
**************************************************************************/
function get_monthly_cal_day_data($key_date, &$ref_day, &$ref_todo_names, &$ref_inline_text1, &$ref_inline_text2){
    $LC_cnt = 0;
    
    // Set ref_day
    list($LC_year, $LC_month, $LC_day) = explode("-",$key_date);
    $ref_day = $LC_day;

    // Set SQL key
    $LC_table         = "todo_daily_time";
    $LC_col_todo_name = "todo_name";
    $LC_col_term      = "period";
    $LC_range         = "'($key_date 00:00:00,$key_date 24:00:00)'::tsrange";

    // Set SQL where
    $LC_array_where = array( $LC_col_term => array( 'ope'  => ' && ',
                                                    'data' => $LC_range)
                           );

    select_all_with_WHERE($LC_array_daily, $LC_table, $LC_array_where);

    foreach($LC_array_daily as $FE_row){
        $LC_cnt++;

        // Put in inline_text2 if Hit_number exceeds 24
	// Until then, put in inline_text1
	if($LC_cnt < 25){
	    // 1~24
	    $ref_inline_text1 .= $FE_row[$LC_col_todo_name] . " " .
                                 trim_term($FE_row[$LC_col_term]) . "\n";
	}
	else
	{
	    // 25~48
	    $ref_inline_text2 .= $FE_row[$LC_col_todo_name] . " " .
                                 trim_term($FE_row[$LC_col_term]) . "\n";
	}

        // Limit todo_names viewing up to 3
        if($LC_cnt < 4){
	    $ref_todo_names   .= $FE_row[$LC_col_todo_name] . "<br>" . "\n";
	}
	else{
	    continue;
	}
    }

    return;
}

/**************************************************************************
FUNCTION_NAME : calculate_start_and_end_date
DISCRIPTION   : 
          IN1 :
          OUT1 :
          RETURN : (void)
**************************************************************************/
function trim_term($str){
    // should be format of hh:mm
    $LC_begin = '';
    $LC_end   = '';

    // start parse
    $LC_tmp = trim($str, "()\"");
    $LC_tmp = str_replace(',',' ', $LC_tmp);
    list($LC_date_start, $LC_time_start, $LC_date_end, $LC_time_end) = explode(" ",$LC_tmp);

    // set start time
    list($LC_hh, $LC_mm, $LC_ss) = explode(":", $LC_time_start);
    $LC_begin = $LC_hh . ":" . $LC_mm;

    // set end time
    list($LC_hh, $LC_mm, $LC_ss) = explode(":", $LC_time_end);
    $LC_end   = $LC_hh . ":" . $LC_mm;

    return $LC_begin . "-" . $LC_end;
}

?>
