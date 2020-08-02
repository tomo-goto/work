<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN1 :
          OUT1 :
          RETURN : (void)
**************************************************************************/
function calculate_todo_span($start_time, $end_time){

    $LC_pointer  = new DateTime();
    $LC_deadline = new DateTime();
    $LC_span = 0;

    // parse start_time and end_time (YYY-MM-DD hh:mm:ss -> "YYYY-MM-DD", "hh:mm:ss")
    list($LC_start_date, $LC_start_time) = explode(" ",$start_time);
    list($LC_end_date  , $LC_end_time  ) = explode(" ",$end_time);

    list($LC_s_year, $LC_s_month , $LC_s_day) = explode("-", $LC_start_date);
    list($LC_s_hour, $LC_s_minute, $LC_s_sec) = explode(":", $LC_start_time);

    list($LC_e_year, $LC_e_month , $LC_e_day) = explode("-", $LC_end_date);
    list($LC_e_hour, $LC_e_minute, $LC_e_sec) = explode(":", $LC_end_time);

    // init DateTime
    $LC_pointer->setDate($LC_s_year, $LC_s_month , $LC_s_day);
    $LC_pointer->setTime($LC_s_hour, $LC_s_minute, $LC_s_sec);

    $LC_deadline->setDate($LC_e_year, $LC_e_month , $LC_e_day);
    $LC_deadline->setTime($LC_e_hour, $LC_e_minute, $LC_e_sec);

    // check to make sure start do not exceeds end
    if($LC_deadline < $LC_pointer){
        return $LC_span;
    }

    // count span
    while( $LC_pointer != $LC_deadline){
        $LC_span++;
	$LC_pointer->modify('+30 minute');
    }

    return $LC_span;
}

/**************************************************************************
FUNCTION_NAME : calculate_start_and_end_date
DISCRIPTION   : 
          IN1 : given_date      -> Given day for base
          IN1 : od_mode         -> whether start from "Monday(static)" or "Given day(dynamic)"
          OUT1 : ref_start_date -> start date of whole table
          OUT2 : ref_end_date   -> end   date of whole table
          RETURN : (void)
**************************************************************************/
function calculate_start_and_end_date($given_date, $od_mode, &$ref_start_date, &$ref_end_date){

    if($od_mode == 'static'){
        // start from Monday
	switch( date('w', $given_date) ){
	    case 0: // Sunday
	        $ref_start_date->modify('-6 days');
		//$ref_end_date ... hold date
		break;
	    case 1: // Monday
	        //$ref_start_date ... hold date
		$ref_end_date->modify('+6 days');
		break;
	    case 2: // Tuesday
	        $ref_start_date->modify('-1 days');
		$ref_end_date->modify('+5 days');
		break;
	    case 3: // Wednesday
	        $ref_start_date->modify('-2 days');
		$ref_end_date->modify('+4 days');
		break;
	    case 4: // Thursday
	        $ref_start_date->modify('-3 days');
		$ref_end_date->modify('+3 days');
		break;
	    case 5: // Friday
	        $ref_start_date->modify('-4 days');
		$ref_end_date->modify('+2 days');
		break;
	    case 6: // Saturday
	        $ref_start_date->modify('-5 days');
		$ref_end_date->modify('+1 days');
		break;
	}
    }
    else if($od_mode == 'dynamic'){
        // start from Given day
	//$ref_start_date ... hold date
	$ref_end_date->modify('+6 days');
    }

    return;
}

?>
