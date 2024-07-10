<?php

namespace App\DTO;

use App\Models\RateModel;

interface ExchangerDTOInterface
{
    public static function toRateModel(array $data): RateModel;
}
