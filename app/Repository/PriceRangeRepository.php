<?php

namespace App\Repository;

use App\Entities\DateRangeEntity;
use App\Repository\Driver\PdoDriver;


class PriceRangeRepository {

    private $_pdoInstance;
    private static $instance;

    private function __construct() {
        $this->_pdoInstance = PdoDriver::getDriver();
    }

    private static function getInstance() {
        if (!self::$instance) {
            self::$instance = new PriceRangeRepository();
        }
        return self::$instance;
    }

    public function executeSelectQuery($query, $args = [])
    {
        $stmt = $this->_pdoInstance->prepare($query);
        $stmt->execute($args);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function executeQuery($query, $args = [])
    {
        $stmt = $this->_pdoInstance->prepare($query);
        return $stmt->execute($args);
    }

    public static function getAll()
    {
        $records =  self::getInstance()->executeSelectQuery("SELECT * FROM price_ranges ORDER BY start");
        $data = [];
        foreach ($records as $row) {
            $data[] = DateRangeEntity::build($row);
        }
        return $data;
    }

    public static function insertAll($records)
    {
        $values = [];
        foreach ($records as $record) {
            $values[] = '('.$record['start'].', '.$record['end'].', '.$record['price'].')';
        }
        self::getInstance()->executeQuery("INSERT INTO price_ranges(start,end,price) VALUES ". implode(',', $values).";");  
    }

    public static function deleteAll() 
    {
        self::getInstance()->executeQuery("DELETE FROM price_ranges");
    }


}