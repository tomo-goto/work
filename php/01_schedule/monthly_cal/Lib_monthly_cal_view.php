<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/

require_once(dirname(__FILE__) . '/Lib_monthly_cal_com.php');

/**************************************************************************
FUNCTION_NAME :view_head 
DISCRIPTION   : 
          IN1 :
          OUT1 :
          RETURN : (void)
**************************************************************************/
function view_monthly_cal_head(){

    // class name
    $LC_class_head = 'head';
    $LC_class_head_flagment = 'head_flagment';

    // html
    $LC_html = <<<EOF
    <div class="$LC_class_head">
        <div class="$LC_class_head_flagment">MON</div>
        <div class="$LC_class_head_flagment">TUE</div>
        <div class="$LC_class_head_flagment">WEN</div>
        <div class="$LC_class_head_flagment">TUR</div>
        <div class="$LC_class_head_flagment">FRI</div>
        <div class="$LC_class_head_flagment">SAT</div>
        <div class="$LC_class_head_flagment">SUN</div>
    </div>
EOF;

    // dump html
    echo $LC_html . "\n";

    return;
}

/**************************************************************************
FUNCTION_NAME :view_monthly_cal 
DISCRIPTION   : 
          IN1 :
          OUT1 :
          RETURN : (void)
**************************************************************************/
function view_monthly_cal($key_month){

    // stracture data
    $LC_blanks = 0;
    $LC_last_date = 0;

    // DateTime
    $LC_datetime = new DateTime();

    // parse key_date to "Year" and "Month"
    list($LC_year, $LC_month) = explode("-", $key_month);

    // setDate(Y, M, D) , setTime(h, m, s)
    $LC_datetime->setDate($LC_year, $LC_month, 1)->setTime(0, 0, 0);

    calculate_blanks_and_last_date($LC_datetime, $LC_blanks, $LC_last_date);

    // view head
    view_monthly_cal_head();

    // view blanks
    view_monthly_cal_blank_days($LC_blanks);

    // view inranges
    for($FOR=$LC_blanks+1 ; $FOR <= $LC_blanks + $LC_last_date ; $FOR++){

        // UpLeft
        if( (1 <= $FOR && $FOR <= 4) || (8 <= $FOR && $FOR <= 11) ){
            view_monthly_cal_inrange_day('UpLeft', $LC_datetime->format('Y-m-d'));
	}

        // UpRight
        if( (5 <= $FOR && $FOR <= 7) || (12 <= $FOR && $FOR <= 14) ){
            view_monthly_cal_inrange_day('UpRight', $LC_datetime->format('Y-m-d'));
	}

        // DownLeft
        if( (15 <= $FOR && $FOR <= 18) ||
	    (22 <= $FOR && $FOR <= 25) ||
	    (29 <= $FOR && $FOR <= 32) ||
	    (36 <= $FOR && $FOR <= 39) ){
            view_monthly_cal_inrange_day('DownLeft', $LC_datetime->format('Y-m-d'));
	}

        // DownRight
        if( (19 <= $FOR && $FOR <= 21) ||
	    (26 <= $FOR && $FOR <= 28) ||
	    (33 <= $FOR && $FOR <= 35) ||
	    (40 <= $FOR && $FOR <= 42) ){
            view_monthly_cal_inrange_day('DownRight', $LC_datetime->format('Y-m-d'));
	}

        $LC_datetime->modify('+1 day');
    }

    return;
}

/**************************************************************************
FUNCTION_NAME :view_monthly_cal 
DISCRIPTION   : 
          IN1 :
          OUT1 :
          RETURN : (void)
**************************************************************************/
function view_monthly_cal_blank_days($blanks){

    // class name
    $LC_class_blank = 'blank day';

    // html
    $LC_html = <<<EOF
        <div class="$LC_class_blank"></div>
EOF;

    for($FOR=0 ; $FOR < $blanks ; $FOR++){
        echo $LC_html . "\n";
    }

    return;
}

/**************************************************************************
FUNCTION_NAME :view_monthly_cal 
DISCRIPTION   : 
          IN1 :
          OUT1 :
          RETURN : (void)
**************************************************************************/
function view_monthly_cal_inrange_day($od_location, $key_date){

    // switch class
    switch($od_location){
        case 'UpLeft':
	    $LC_class_polygon = 'hidden location-UpLeft inline_polygon_Up';
	    $LC_class_message = 'hidden location-UpLeft inline_message';
 	    break;
        case 'UpRight':
	    $LC_class_polygon = 'hidden location-UpRight inline_polygon_Up';
	    $LC_class_message = 'hidden location-UpRight inline_message';
	    break;
        case 'DownLeft':
	    $LC_class_polygon = 'hidden location-DownLeft inline_polygon_Down';
	    $LC_class_message = 'hidden location-DownLeft inline_message';
	    break;
	case 'DownRight':
	    $LC_class_polygon = 'hidden location-DownRight inline_polygon_Down';
	    $LC_class_message = 'hidden location-DownRight inline_message';
	    break;
    }

    // class name
    $LC_class_day         = 'inrange day';
    $LC_class_show        = 'show';
    $LC_class_inline_text = 'inline_text';

    // Data
    $LC_day          = '';
    $LC_todo_names   = '';
    $LC_inline_text1 = '';
    $LC_inline_text2 = '';

    get_monthly_cal_day_data($key_date, $LC_day, $LC_todo_names, $LC_inline_text1, $LC_inline_text2);

    // html
    $LC_html = <<<EOF
        <div class="$LC_class_day">$LC_day<br>
            <span class="$LC_class_show">$LC_todo_names</span>
            <div class="$LC_class_polygon"></div>
            <div class="$LC_class_message">
                <pre class="$LC_class_inline_text">$LC_inline_text1</pre>
                <pre class="$LC_class_inline_text">$LC_inline_text2</pre>
            </div>
        </div>
EOF;

    // dump html
    echo $LC_html . "\n";

    return;
}

?>
