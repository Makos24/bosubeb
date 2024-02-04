<?php

function to_num($val){
    return floatval(preg_replace('/[^\\d.]/', '', $val));
}

function to_nums($vals){
    $a = array();
    foreach($vals as $val){
        $a[] = floatval(preg_replace('/[^\\d.]/', '', $val));
    }
    return $a;
}