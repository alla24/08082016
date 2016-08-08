<?php
/**
 * Created by PhpStorm.
 * User: AIR
 * Date: 28.07.2016
 * Time: 19:21
 */

function GetDBParams() {

    if (!file_exists('secret.txt')){
        return false;
    }

    $arrLogin = file('secret.txt');

    $result = array();
    foreach($arrLogin as $row) {

     $result = explode("\t", $row);

     }

    return $result;
}

//print_r(GetDBParams());

