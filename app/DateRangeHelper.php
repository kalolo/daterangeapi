<?php

namespace App;

use App\Entities\DateRangeEntity;


class DateRangeHelper
{

    public static function merge($ranges, DateRangeEntity $new_range = null)
    {
        $data = self::prepareArrayRange($ranges);

        if ( $new_range  ) {
            $data = self::addNewRange($data, $new_range);
        }
        
        $outputRanges = [];
        $range = null;

        for ($key = 1; $key <= array_key_last($data); $key++) {

            if (!isset($data[$key]) || !$data[$key]) {
                if ($range) {
                    $outputRanges[] = $range->toArray();
                    $range = null;
                    
                }
                continue;
            }

            if (!$range) {
                $range = $data[$key];
                $range->setStart($key);
                $range->setEnd($key);
                continue;
            }

            if ($data[$key]->getPrice() == $range->getPrice()) {
                $range->setEnd($key);
            } else {
                $outputRanges[] = $range->toArray();
                $range = $data[$key];
                $range->setStart($key);
                $range->setEnd($key);
            }
        }

        $outputRanges[] = $range->toArray();


        return $outputRanges;
    }

    private static function prepareArrayRange($ranges)
    {
        $data = [];
        foreach ($ranges as $range) {

            for ($x = $range->getStart(); $x <= $range->getEnd(); $x++) {
                if (!isset($data[$x]) || $data[$x]->getPrice() < $range->getPrice())
                    $data[$x] = $range;
            }
        }

        ksort($data);
        return $data;
    }

    private static function addNewRange($data, $new_range) 
    {
        for ($x = $new_range->getStart(); $x <= $new_range->getEnd(); $x++) {
            $data[$x] = $new_range;
        }
        ksort($data);
        return $data;
    }
}

