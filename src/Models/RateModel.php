<?php

namespace App\Models;

class RateModel
{
    private float $rate;

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }
}
