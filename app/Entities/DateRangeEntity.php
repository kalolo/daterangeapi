<?php

namespace App\Entities;

class DateRangeEntity implements \JsonSerializable {

    private $id;
    private $start;
    private $end;
    private $price;

    public function __construct(){

    }

    public function getId() { return $this->id; }
    public function getStart() { return $this->start; }
    public function getEnd() { return $this->end; }
    public function getPrice() { return $this->price; }

    public function setId($val) {
        $this->id = $val;
        return $this;
    }

    public function setStart($val) {
        $this->start = $val;
        return $this;
    }

    public function setEnd($val) {
        $this->end = $val;
        return $this;
    }

    public function setPrice($val) {
        $this->price = $val;
        return $this;
    }

    public static function build($data) {
        if (! $data instanceof \stdClass) $data = (object)$data;
        return self::_build($data);
    }

    private static function _build(\stdClass $data) {
        $instance = new DateRangeEntity();
        $instance->setId($data->id ?? null)->setStart($data->start ?? null )->setEnd($data->end ?? null)->setPrice($data->price ?? null);
        return $instance;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'start' => $this->getStart(),
            'end' => $this->getEnd(),
            'price' => $this->getPrice()
        ];
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'start' => $this->getStart(),
            'end' => $this->getEnd(),
            'price' => $this->getPrice()
        ];
    }
}
