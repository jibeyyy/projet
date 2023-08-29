<?php

namespace App\Utils;

use \PDO;

class Database {
    private $dsn;
    private static $_instance;
    private function __construct() {
        $config = parse_ini_file(__DIR__ . '/../config.ini');
        try {

            $this->dsn = new PDO("mysql:host={$config['dbhost']};dbname={$config['dbname']}", $config['dbuser'], $config['dbpass'],array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            echo 'Connexion réussie';
        } catch (\PDOException $e) {
            print 'Erreur de connexion : ' . $e->getMessage();
            die();
        }
    }
    public static function connectPDO() {
        if (empty(self::$_instance)) {
            self::$_instance = new self(); 
        }
        return self::$_instance->dsn;
    } 
}
?>