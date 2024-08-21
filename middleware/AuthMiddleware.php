<?php


class AuthMiddleware{

    

    public function __construct($args){
        



        if(!isset($_SESSION['uid']) && $args['access'] === true){
            Router::redirect(config("no_auth_redirect"));
        } else if(isset($_SESSION['uid']) && $args['access'] === false){
            Router::redirect(config("dashboard_redirect"));
        } 
        
        

    }

}