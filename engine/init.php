<?php

require 'engine/lib/config.php';
require 'engine/lib/engine.php';
require 'engine/lib/requestHandler.php';
require 'engine/lib/functions.php';
require 'engine/lib/database.php';

class init {

    function __construct() {
        
        /**
         * Stworzenie instancji requestHandlera
         */
        global $request;
        $request = \core\RequestHandler::getInstance();
        
        /**
         * Stworzenie instancji bazy danych
         */
        global $database;
        $database = \core\Database::getInstance();
        
        /**
         * Uruchomienie strony wykrytej za pomocą requestHandlera
         */
        core\Engine::run($request->getPage());        
        
    } 
}
