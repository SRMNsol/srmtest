<?php

namespace App\Entity;

trait MoneyTrait
{
    public static function eq($value1, $value2)
    {
        return !self::gt($value1, $value2) && !self::lt($value1, $value2);
    }

    public static function gt($value1, $value2)
    {
        return (self::round($value1) - self::round($value2)) >= 0.01;
    }

    public static function lt($value1, $value2)
    {
        return (self::round($value2) - self::round($value1)) >= 0.01;
    }

    /**
     * Rounding down value to 2 decimal points
     */
    public static function round($value)
    {
        return floor($value * 100) / 100;
    }
}
