<?php

class Functions {
    

    public static function pp($var){
        echo '<pre>';
        if (is_array($var)) {
            print_r($var);
        } else {
            var_dump($var);
        }
        echo '</pre>';
    }
    
    public static function redirect($url) {
        header("Location: " . $url);
        die();
    }    
    
}
