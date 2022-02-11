<?php

/*
 *
 *       Date              User               Description
 * ------------------------------------------------------------------------------
 *      2/11/22           Aaron Potter        Refactoring initial functionality
 * 
 *  
 */

class Database {

    private static $dsn = 'mysql:host=localhost;dbname=spiderBeGoneCo';
    private static $username = 'spuser';
    private static $password = 'hillo';
    private static $db;

    private function __construct() {
        
    }

    public static function getDB() {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn,
                        self::$username,
                        self::$password);
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
//                include('../errors/database_error.php');
                exit();
            }
        }
        return self::$db;
    }

}


?>