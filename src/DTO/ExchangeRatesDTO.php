<?php

namespace App\DTO;

use App\Models\RateModel;

class ExchangeRatesDTO implements ExchangerDTOInterface
{
    public static function toRateModel(array $data): RateModel
    {
        $rate = new RateModel();
        $rate->setRate($data['rate']);
        return $rate;
    }
}
