<?php

include_once __DIR__."/kernel/helpers.php";


// generar sql

$migration_dir = __DIR__."/database/migrations";

$migrations =  array_diff(scandir($migration_dir), array('..', '.'));

$sql_migration = [];

foreach($migrations as $migration){
    include_once $migration_dir."/".$migration;
}


switch(ENV("DB")){
    case "mysql":
        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try{

        
            $link = new mysqli(
                ENV("MYSQL_HOST"),
                ENV("MYSQL_USERNAME"),
                ENV("MYSQL_PASSWORD"),
                ENV("MYSQL_SCHEMA"),
                ENV("MYSQL_PORT")
            );
        
            
            foreach ($sql_migration as $sql) {
                $link->query($sql);
            }
            
            


        } catch(Exception $e){
            
           if($e->getCode() == "1049"){
            $sql_generate = [];

            include_once __DIR__."/database/generate/schema.php";


                $link = new mysqli(
                    ENV("MYSQL_HOST"),
                    ENV("MYSQL_USERNAME"),
                    ENV("MYSQL_PASSWORD"),
                    "",
                    ENV("MYSQL_PORT")
                );

                foreach ($sql_generate as $sql) {
                    $link->query($sql);
                }


                $linknew = new mysqli(
                    ENV("MYSQL_HOST"),
                    ENV("MYSQL_USERNAME"),
                    ENV("MYSQL_PASSWORD"),
                    "tiki_fw",
                    ENV("MYSQL_PORT")
                );
            
                
                foreach ($sql_migration as $sql) {
                    $linknew->query($sql);
                }

                


           } else {
           
                echo "Error: ".$e->getMessage()."\n";
                
           }
        }




    break;
}


// crear carpetas

mkdir("./storage", 0777);
mkdir("./storage/logs", 0777);
mkdir("./storage/pdf", 0777);
mkdir("./storage/twigcache", 0777);