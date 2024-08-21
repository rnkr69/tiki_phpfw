<?php



class Logger{

    public const LOG = "|LOG|";
    public const WARNING = "|WARNING|";
    public const ERROR = "|ERROR|";


    public static function log($type, $message){


        $stream = "";
        $stream .= "[".date("Y-m-d H:i:s")."] ";
        $stream .= $type." ";
        if(is_object($message) || is_array($message)){
            $stream .= json_encode($message);
        } else {
            $stream .= $message;
        }
        $stream .= "\n";
        
        file_put_contents(__DIR__."/../storage/logs/tiki.log", $stream, FILE_APPEND);


    }


}

