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
          IN  :
          OUT : (int)
**************************************************************************/
function execute_insert(){

    // input
    $LC_input = $_POST;

    // switch by tag
    switch($LC_input['ins_tag']){
        case 'ins_parent':
	    break;
        case 'ins_child':
	    break;
        case 'ins_daily':
	    break;
        case 'ins_special':
	    break;
        case 'ins_littleimp':
	    break;
    }

    return;
}

?>
