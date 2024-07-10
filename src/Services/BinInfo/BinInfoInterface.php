<?php

namespace App\Services\BinInfo;

use App\Models\BinInfoModel;

interface BinInfoInterface
{
    public function getBinInfo(string $bin): BinInfoModel;
}
