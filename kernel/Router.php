<?php


include_once __DIR__."/../kernel/Http.php";
include_once __DIR__."/../kernel/Controller.php";
include_once __DIR__."/../kernel/DB.php";
include_once __DIR__."/../kernel/Model.php";
include_once __DIR__."/../kernel/Logger.php";
include_once __DIR__."/../kernel/Validator.php";
include_once __DIR__."/../kernel/i18n.php";

include_once __DIR__."/../model/User.php";


include_once __DIR__."/../routes/main.php";

include_once __DIR__."/../config/main.php";
include_once __DIR__."/../config/middlewares.php";

include_once __DIR__."/../tools/MyMail.php";


$user = null;

class Router {

 

    public static function route(){

        global $routes;    

        if(isset($routes[Http::getPath()] )){

            self::send($routes[Http::getPath()]);

        } else {
            self::_404();
        }
    }


    public static function redirect($path){
        header('Location: '.$path);
        exit();
    }

    public static function send($path){

        self::setMiddleware($path);

        $conts = self::getController($path);

    }

    private static function setMiddleware($path){

        global $mids;

        $mid = [config("middleware")];

        if(isset($path[2])){
            $mid = $path[2];
        }

        foreach($mids[$mid[0]] as $middlewareClass => $args){

            include_once __DIR__."/../middleware/".$middlewareClass.".php";

            $midClass=new $middlewareClass($args);

        }

        


        

    }

    private static function getController($path){

        $conts_pre = array_diff(scandir(__DIR__."/../controllers"), array('..', '.'));
        $conts = [];

        foreach($conts_pre as $cont_pre){

            $conts[str_replace(".php", "", $cont_pre)] = str_replace(".php", "", $cont_pre);
        }


        $controller = $path[0];
        $function = $path[1];


        if(!isset($conts[$controller])){
            self::_404();
        }


        try{
            include_once __DIR__."/../controllers/".$conts[$controller].".php";

            $controlerClass=$conts[$controller];

            $conClass=new $controlerClass();

            if(method_exists($conClass, $path[1])){
                $method = $path[1];
                $conClass->$method();
            } else {
                self::_500("No Method");
            }


        } catch(Exception $e){
            print_r($e);
            self::_500($e->getMessage());
        }
        

        

    }

    public static function _404(){
        
        Controller::getView("404");
        die();
    }

    public static function _500($e = null){
        
        $opts = [];
        if(ENV("ENVIRONMENT") == "dev" && $e != null){
            $opts = ["error" => $e];
        }

        Controller::getView("500", $opts);
        die();
    }


    
}

function user(){
    global $user;

    if($user != null){
        return $user;
    }

    if(isset($_SESSION['uid'])){
        
        $user = new User();
        $user = $user->get($_SESSION['uid']);
        return $user;
    } else {
        return null;
    }

}
    