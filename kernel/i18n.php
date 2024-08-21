<?php

class i18n {

    // false = use the standard ITEF 2/3 letter "en" "es" "yue"  [recomended]
    // true = use the ITEF variants (5-n letters) "en-US" "es-MX" "yue-Hant-HK"
    private $langVariants = false;
    private $fallback = "en";

    private static $keys;

    public function __construct(){

        $this->fallback = config("i18n_fallback");
        $this->langVariants = config("i18n_langVariants");

        $filename = __DIR__."/../i18n/".$this->getUserLangs()[0].".json";

        foreach($this->getUserLangs() as $ulang){
            
            $vars = json_decode(@file_get_contents($filename), true);
            if($vars != null && $vars != ""){
                break;
            }
            
        }
        
        self::$keys = $vars;

    }

    // using vsprintf as formatter

    public static function __callStatic($key, $args=[]){

        $hey = self::$keys;

        if(strpos($key, "_") !== false ){
            $ex = explode("_", $key);
            foreach($ex as $v){
                $hey = &$hey[$v];
            }
            return vsprintf($hey, $args);
        } else {

            if(isset(self::$keys[$key])){
                return vsprintf(self::$keys[$key], $args);
            } else {
                return "";
            }
        }

        
    }

    // ordered by GET, SESSION, ACCEPT_LANG, fallback

    private function getUserLangs(){

        $langs = array();

        if (isset($_GET['l']) && is_string($_GET['l'])) {
            $langs[] = $_GET['l'];
        }

        if (isset($_SESSION['l']) && is_string($_SESSION['l'])) {
            $langs[] = $_SESSION['l'];
        }

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $s_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            foreach ($s_langs as $s_lang) {
                $s_l = strtolower(explode(';q=', $s_lang)[0]);

                if(!$this->langVariants){
                    $s_l = explode('-', $s_l)[0];
                }
                
                
                $langs[] = $s_l;
            }
        }

        $langs[] = $this->fallback;

        $langs = array_unique($langs);

        return $langs;

    }



}

$i18n = new i18n();