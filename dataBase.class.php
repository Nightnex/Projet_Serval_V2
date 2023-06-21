<?php

/*
 * Class dataBase
 * Effectue la connexion à la base de donnée
 */
    class dataBase extends PDO {
        const HOST = "localhost";
        const USER = "root";
        const PASS = "root";
        const DBNAME = "fpview_second";
    
        public function __construct() {
            $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DBNAME;
            parent::__construct($dsn, self::USER, self::PASS);
        }
    }
?>