<?php


class CSRFMiddleware{

    

    public function __construct($args){
        
        

        if (isset($_SESSION["ttk"])
            && isset($_SERVER['REQUEST_METHOD'])
            && $_SERVER['REQUEST_METHOD'] === 'POST'
            && !empty($_POST)
        ) {

            if(!isset($_POST['CSRF_TOKEN'])){
                Controller::getView("500", ["error" => "CSRF Token not found"]);
                die();
            }

            if(!hash_equals((string) $_SESSION['ttk'], (string) $_POST['CSRF_TOKEN'])){
                Controller::getView("500", ["error" => "CSRF Token missmatch "]);
                die();
            }
            
        }


        
        

    }

}