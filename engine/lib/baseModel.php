<?php

namespace core;

/**
 * Klasa bazowa dla modelu strony
 */
abstract class BaseModel {

    /**
     * Tablica danych które zostaną przekazane do widoku
     * @var type 
     */
    private $data = [];

    public function getData() {
        return $this->data;
    }

    public function addData($name, $var) {
        $this->data[$name] = $var;
    }

}
