<?php

    $array = array();

/*
    $array = ( [tomo] => gotou ,
               [masa] => GOTOU );
*/
    $array['tomo'] = 'gotou';
    $array['masa'] = '';
    //$array['masa'] = 'GOTOU';

    echo "big bro:" . $array['tomo'] . " little bro:" . $array['masa'] . "\n";

    if( empty($array['tomo'])){
        echo "Big bro Empty!\n";
    }

    if( empty($array['masa'])){
        echo "Little bro Empty!\n";
    }

    if( empty('')){
        echo "Pure Empty!\n";
    }

?>
