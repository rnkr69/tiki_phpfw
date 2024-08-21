<?php


class User extends Model{

    
    protected $table = "users";
    protected static $tables = "users";


    public function setPassword($pwd){

        $this->password = SHA1($pwd);

    }

    public static function getByEmail($email){

        $user = self::getWhere([["email = ", $email]]);
        if($user != null){
            return $user[0];
        } else {
            return null;
        }
        


    }


    public function save(){
        
        parent::save();
        $u = user();
        if($u != null && $this->user_id == $u->user_id){
            $_SESSION['uid'] = $this->user_id;
            
        }
        
    }

    public static function authLogin($email, $pwd){

        $user = self::getWhere([["email = ", $email]]);
        if(!empty($user)){
            $user = $user[0];
            if($user->password == SHA1($pwd)){

                $_SESSION['uid'] = $user->user_id;
            
                return true;

            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    
}