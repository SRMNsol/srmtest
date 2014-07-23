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
        return (round($value1, 2) - round($value2, 2)) >= 0.01;
    }

    public static function lt($value1, $value2)
    {
        return (round($value2, 2) - round($value1, 2)) >= 0.01;
    }
}
