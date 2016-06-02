<?php

namespace core;

require 'engine/lib/rain.tpl.class.php';

class Engine {
    
    /**
     * Sprawdzenie czy istnieje model wybranej strony
     * @param type $page
     * @return boolean
     */

    public static function model_exist($page) {
        $path = 'app/models/';
        $models = scandir($path);
        if (in_array($page . '.php', $models)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Strawdzenie czy istanieje widok wybranej strony
     * @param type $page
     * @return boolean
     */

    public static function view_exist($page) {
        $path = 'app/views/';
        $views = scandir($path);
        if (in_array($page . '.html', $views)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Zwraca wybraną stronę lub index w przypadku jej braku
     * @param type $page
     * @return string
     */

    public static function page_exist($page) {
        $model_exist = self::model_exist($page);
        $view_exist = self::view_exist($page);
        if ($model_exist && $view_exist) {
            return strtolower($page);
        }
        return 'index';
    }

    /**
     * Tutaj następuje uruchomienie obsługi wybranej strony, a następnie wczytanie jej widoku.
     * @param type $page
     */
    public static function run($page) {

        $final_page = self::page_exist($page);
        $path = 'app/models/' . $final_page;
        require_once $path . '.php';

        $class_name = '\Models\\' . $final_page;
        $object = new $class_name();

        $t = new \RainTPL();
        $t->configure('tpl_dir', "app/views/");
        $t->configure('cache_dir', "cache/");
        $t->configure('php_enabled', true);
        $t->configure('base_url', '/');
        $t->configure('tpl_ext', 'html');

        if (!empty($object->getData())) {
            foreach ($object->getData() as $key => $value) {                
                $t->assign($key, $value);
            }
        }

        $t->draw('header');
        $t->draw($final_page);
        $t->draw('footer');
    }

}
