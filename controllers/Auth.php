<?php

include_once __DIR__."/../tools/MyMail.php";



class Auth extends Controller{


    public function __construct(){

    }


    public function index(){

        
        $query = Http::getAllQuery();
        $options = [];
        if(isset($query['email'])){
            
            $error = false;

            

            
            if(User::authLogin($query['email'], $query['password'])){
                
                Router::redirect(config("dashboard_redirect"));
            } else {
                $options = ["error_msg" => "Login Error"];
            }

        }
        
        

        $this->getView("login", $options);
    }


    public function validate(){

    }


    public function register(){

        $query = Http::getAllQuery();

        $error = [];
        
        
 
        if(isset($query['name'])){
            
            $fields = [
                "name" => ["required"], 
                "last_name" => ["required"], 
                "email"=>["required", "email"], 
                "password"=>["required", "password","repassword"], 
                "re_password"=>["required", "repassword"]
            ];

            $error = Validator::test($fields, $query);

            
            

            if(empty($error)){
                User::getByEmail($query['email']);
                if($u == null){

                    try{
                        $user = new User();
                        $user->name = trim($query["name"]);
                        $user->last_name = trim($query["last_name"]);
                        $user->email = trim($query["email"]);
                        $user->password = sha1(trim($query["password"]));
                        $user->save();

                        
                        //Now you only need to set things that are different from the defaults you defined
                        MyMail::welcomeMail($user);


                        User::authLogin($query['email'], $query['password']);
                        Router::redirect(config("dashboard_redirect"));


                    } catch(Exception $e){
                        Router::_500($e->getMessage());
                        
                    }
                    




                } else {
                    
                    $error["email"] = "email already registered";
                }
            }
            
            

        }
       

        $this->getView("register", ["error" => $error]);
    }


    public function logout(){
        global $user;
        $user = null;
        
        session_destroy();  
        session_unset();
        $_SESSION = [];
        Router::redirect("/");

    }

    public function testmail(){

        $user = User::get("1d28e937-153b-4a1b-802a-73ffb9aaf8a8");

        MyMail::welcomeMail($user);



    }

    

}