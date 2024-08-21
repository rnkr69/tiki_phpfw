<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();


require __DIR__.'/../vendor/autoload.php';

include_once __DIR__."/../kernel/helpers.php";

include_once __DIR__."/../kernel/Router.php";


Router::route();

