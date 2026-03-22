<?php


class User extends Model{

    
    protected $table = "users";
    protected static $tables = "users";


    public function setPassword($pwd){

        $this->password = password_hash($pwd, PASSWORD_DEFAULT);

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
            $hash = $user->password;

            if (is_string($hash) && password_verify($pwd, $hash)) {
                $_SESSION['uid'] = $user->user_id;
                return true;
            }

            if (is_string($hash) && strlen($hash) === 40 && ctype_xdigit($hash)
                && hash_equals($hash, sha1($pwd))) {
                $user->setPassword($pwd);
                $user->save();
                $_SESSION['uid'] = $user->user_id;
                return true;
            }

            return false;
        }

        return false;

    }

    
}