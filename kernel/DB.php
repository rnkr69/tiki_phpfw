<?php



class DB {

    public $link;
    
    public function __construct(){
        
        switch(ENV("DB")){
            case "mysql":
                
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

                try{

                
                    $this->link = new mysqli(
                        ENV("MYSQL_HOST"),
                        ENV("MYSQL_USERNAME"),
                        ENV("MYSQL_PASSWORD"),
                        ENV("MYSQL_SCHEMA"),
                        ENV("MYSQL_PORT")
                    );
                

                } catch(Exception $e){
                    
                   if($e->getCode() == "1049"){

                    Controller::getView("500",["error" => "Schema ".ENV("MYSQL_SCHEMA")." doesnt exists."]);

                   } else {
                   
                    Controller::getView("500",["error" => $e->getMessage()]);
                   }
                }


            break;
        }

        

    }

public static function conn(){
    global $conn;

    return $conn;

}



}

$conn = new DB();