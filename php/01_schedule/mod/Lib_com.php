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
function view_select($array, $input_name, $key_child, $key_parent){

    echo "<select name=\"" . $input_name . "\">\n";

    if( is_null($key_parent) ){
        foreach($array as $FE_row){
            echo "    <option value=\"" . $FE_row[$key_child] . "\">" . $FE_row[$key_child] . "</option>\n";
        }
    }
    else{
        foreach($array as $FE_row){
            echo "    <option value=\"" . $FE_row[$key_child] . "\" data-val=\"" . $FE_row[$key_parent] . "\">" . $FE_row[$key_child] . "</option>\n";
        }
    }

    echo "</select>\n"; # end of select

    return;
}

?>
