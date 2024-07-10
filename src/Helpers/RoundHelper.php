<?php

namespace App\Helpers;

class RoundHelper
{
    public static function ceilAmount(float $amount): float
    {
        return ceil($amount*100)/100;
    }
}
