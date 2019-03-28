<?php

namespace App\Repository\Driver;

class PdoDriver
{
    private static $pdoInstance;

    private function __construct() { }

    public static function getDriver() {
        if (!self::$pdoInstance) {
            $properties = include 'properties.php';
            $dbname = $properties['database'] ?? 'daterangeapi';
            $host = $properties['host'] ?? 'localhost';
            $username = $properties['username'] ?? 'root';
            $password = $properties['password'] ?? '';
            self::$pdoInstance =  new \PDO("mysql:dbname=$dbname;host=$host", $username, $password, null);
        }
        return self::$pdoInstance;
    }

}