<?php

namespace core;
/**
 * Klasa realizująca obsługę przychodzących requestów. Jako pierwszy parametr z adres odczytywana jest strona, a następnie pozostałe parametry.
 */
class RequestHandler {

    private static $instance = null;
    private $page = null;
    private $params = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new RequestHandler();
        }
        return self::$instance;
    }

    public final function getPage() {
        return $this->page;
    }

    public final function getParams() {
        return $this->params;
    }

    public final function getUriParams() {
        return $this->params['URI'];
    }

    public final function getGetParams() {
        return $this->params['GET'];
    }

    public final function getPostParams() {
        return $this->params['POST'];
    }

    public function __construct() {
        $Uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
        $Uri = explode("/", trim($Uri, "/"));
        
        if (count($Uri)) {
            if (!empty($Uri[0])) {
                $this->page = $Uri[0];
                unset($Uri[0]);
            }
        }

        $params = [];
        $tmp = "";
        foreach ($Uri as $key => $value) {

            if (strlen($tmp) == 0) {
                $tmp = $value;
            } else {
                $params[$tmp] = $value;
                $tmp = "";
            }
        }
        if (strlen($tmp)) {
            $params[$tmp] = NULL;
        }

        $this->params = [
            'URI' => $params,
            'GET' => $_GET,
            'POST' => $_POST
        ];
    }

}
