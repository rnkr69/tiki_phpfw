<?php


class Controller {

    private static $base_path = __DIR__."/../views/";
    private static $base_cache = __DIR__."/../storage/twigcache/";


   

    private static function setUpView(){
        
        $view_args = [

            "title" => ENV("APP_NAME"),
            "url" =>  ENV("APP_URL"),


        ];
        
        $user = user();
        if($user != null){
            // twig doesnt work with the magic _get method
            $view_args["user"] = $user->getArray();
        }

        

        return $view_args;

    }


    public static function getView($view, $args = [], $return_html = false){
       
       
        $loader = new \Twig\Loader\FilesystemLoader(self::$base_path);

        $options = [];
        //$options = ["strict_variables"=>true];
        if(ENV("ENVIRONMENT") == "prod"){
            $options = [
                'cache' => self::$base_cache,
            ];
        }



        $args = array_merge($args, self::setUpView());

        

        $twig = new \Twig\Environment($loader, $options);

        $tpl = $twig->render($view.'.html', $args);

        $tpl_e = explode("</form>", $tpl);
        
        if(count($tpl_e) > 1){
            
            $t_token = "ttk_".uniqid();
            
    
            $token_input = "\n<input type='hidden' name='CSRF_TOKEN' value='".$t_token."' />\n";
    
            $_SESSION['ttk'] = $t_token;
    
            $tpl = implode($token_input."</form>", $tpl_e);
        } 

       

        if($return_html){
            return $tpl;
        } else {
            echo $tpl;
        }

        

    }


    public static function sendJson($obj){

        header('Content-Type: application/json');

        if(!self::validateIsJson($obj)){
            echo json_encode($obj);
        } else {
            echo $obj;
        }
        



    }

    public static function validateIsJson($string){
        if(!is_string($string)){
            return false;
        }
        json_decode($string);
    
        return json_last_error() === JSON_ERROR_NONE;
    }

   

}
