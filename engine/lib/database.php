<?php

namespace core;

class Database {

    private static $instance = null;
    private $dbHandler = null;
    private $dbType = "mysql";
    private $dbHost = DB_HOST;
    private $dbUser = DB_USER;
    private $dbName = DB_NAME;
    private $dbPassword = DB_PASS;

    private function __construct() {
        $this->dbHandler = new \PDO($this->dbType . ':host=' . $this->dbHost . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPassword, [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_PERSISTENT => true]);
        self::$instance = $this;
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new \core\Database();
        }
        return self::$instance;
    }

    public function query($string) {
        try {
            if (empty($string)) {
                throw new Exception("String zapytania jest pusty");
            }
            if (preg_match('/insert/', strtolower($string))) {
                $this->dbHandler->exec($string);
                return $this->dbHandler->lastInsertId();
            } else if (preg_match('/update/', strtolower($string))) {
                return $this->dbHandler->exec($string);
            } else {
                return $this->dbHandler->query($string)->fetchAll(\PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return false;
        }
    }

}
