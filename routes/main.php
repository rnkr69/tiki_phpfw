<?php

$routes = [

    "/" => ["Main", "index"],
    "/documentation" => ["Main", "documentation"],
    "/register" => ["Auth", "register"],
    "/login" => ["Auth", "index"],

    "/logout" => ["Auth", "logout", ["auth"]],
    "/dashboard" => ["Dashboard", "index", ["auth"]],
    "/charts" => ["Dashboard", "charts", ["auth"]],
    "/tables" => ["Dashboard", "tables", ["auth"]]

];