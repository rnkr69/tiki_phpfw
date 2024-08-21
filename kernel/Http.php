<?php



class Http {



    

    public static function getPath(){

        $uri = parse_url($_SERVER['REQUEST_URI']);

        return $uri["path"];

    }

    public static function getQuery($id){

        if(isset($_REQUEST[$id])){
            return $_REQUEST[$id];
        } else {
            return "";
        }

    }

    public static function getAllQuery(){

        return $_REQUEST;
    }


}