<?php

namespace App\Helpers;

use App\Models\BinInfoModel;

class CommissionHelper
{
    private const EU_COMMISSION = 0.01;
    private const OTHER_COMMISSION = 0.02;

    public static function getCommission(BinInfoModel $binInfo): float
    {
        return CountryChecker::isEu($binInfo->getAlpha2()) ? self::EU_COMMISSION : self::OTHER_COMMISSION;
    }
}
