<?php

$env = parse_ini_file(__DIR__."/../.env");


function ENV($arg){
    global $env;

    if(isset($env[$arg])){
        return $env[$arg];
    } else {
        return "";
    }



}

function config($arg){
    global $config;

    if(isset($config[$arg])){
        return $config[$arg];
    } else {
        return "";
    }

}

