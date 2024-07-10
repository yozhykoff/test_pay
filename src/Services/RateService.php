<?php

namespace App\Services;

use App\Models\RateModel;
use App\Models\RowModel;
use App\Services\Collections\RatesCollection;

readonly class RateService
{
    private const DEFAULT_CURRENCY = 'EUR';

    public function __construct(
        private RatesCollection $ratesCollection,
    ) {
    }

    public function getAmount(RowModel $rowModel): float
    {
        $rate = $this->ratesCollection->getRateByCurrency($rowModel->getCurrency());

        return $rowModel->getAmount() / $this->getRate($rowModel, $rate);
    }

    private function getRate(RowModel $rowModel, RateModel $rate): float|int
    {
        if ($rowModel->getCurrency() === self::DEFAULT_CURRENCY || !$rate->getRate()) {
            return 1;
        }

        return $rate->getRate();
    }
}
