<?php


class CSRFMiddleware{

    

    public function __construct($args){
        
        

        if(isset($_SESSION["ttk"]) && !empty($_REQUEST)){

            if(!isset($_REQUEST['CSRF_TOKEN'])){
                Controller::getView("500", ["error" => "CSRF Token not found"]);
                die();
            }

            if($_REQUEST['CSRF_TOKEN'] != $_SESSION['ttk']){
                Controller::getView("500", ["error" => "CSRF Token missmatch "]);
                die();
            }
            
        }


        
        

    }

}