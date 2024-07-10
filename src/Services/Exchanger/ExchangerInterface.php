<?php

namespace App\Services\Exchanger;

use App\Services\Collections\RatesCollection;

interface ExchangerInterface
{
    public function loadRates(RatesCollection $ratesCollection): void;
}
