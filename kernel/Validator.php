<?php

class Validator {

    public static function test($fields, $args){

        // $fields son los campos dados por el usuario
        // $args son los datos enviados en el formulario
        $messages = [
            "required" => i18n::validations_required(),
            "repassword" => i18n::validations_repassword(),
            "password" => i18n::validations_password(),
            "email" => i18n::validations_email()
        ];


        $errors = [];

        foreach($fields as $field => $validators){

            foreach($validators as $validator){

                if(!self::$validator($field, $args)){
                    $errors[$field] = $messages[$validator];
                }

            }

        }

        
        return $errors;
        

    }

    private static function repassword($field, $args){


        if(isset($args[$field]) && trim($args[$field]) != "" && trim($args[$field] != null)){
            return true;
        }

        return false;
    }

    private static function password($field, $args){


        if(isset($args[$field]) && trim($args[$field]) != "" && trim($args[$field] != null)){
            return true;
        }

        return false;
    }

    private static function email($field, $args){


        if (filter_var($args[$field], FILTER_VALIDATE_EMAIL)) {
            return true;
        } 

        return false;
    }

    private static function required($field, $args){


        if(isset($args[$field]) && trim($args[$field]) != "" && trim($args[$field] != null)){
            return true;
        }

        return false;
    }


}