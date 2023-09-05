<?php

namespace App\Utils;

use \PDO;

class DataBase {
    private static $_instance;
    private $pdo;

    private function __construct() {
        $dbhost = 'db.3wa.io';
        $dbname = 'jeanbaptisteafonso_DjueKoffi';
        $dbuser = 'jeanbaptisteafonso';
        $dbpass = 'be72b7d7aaf3a17b1ab9731cc391f4f7';

        try {
            $this->pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

        return self::$_instance->pdo;
    }
}
?>