<?php

namespace App\Services\Collections;

use App\Models\RateModel;

class RatesCollection
{
    private array $rates = [];

    private RateModel $emptyRateModel;

    public function __construct()
    {
        $this->emptyRateModel = new RateModel();
        $this->emptyRateModel->setRate(0);
    }

    public function addRate(string $currency, RateModel $rate): void
    {
        if (!isset($this->rates[$currency])) {
            $this->rates[$currency] = $rate;
        }
    }

    public function getRateByCurrency(string $currency): RateModel
    {
        if (!isset($this->rates[$currency])) {
            return $this->emptyRateModel;
        }
        return $this->rates[$currency];
    }
}
