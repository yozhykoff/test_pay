<?php

namespace Helpers;

use App\Helpers\CommissionHelper;
use App\Models\BinInfoModel;
use PHPUnit\Framework\TestCase;

#[CoversClass(CommissionHelper::class)]
class CommissionHelperTest extends TestCase
{
    #[CoversFunction('loadRates')]
    public function testEUCommission()
    {
        $billingInfo = new BinInfoModel();
        $billingInfo->setAlpha2('AT');
        $this->assertEquals(CommissionHelper::getCommission($billingInfo), 0.01);
    }

    #[CoversFunction('loadRates')]
    public function testNotEUCommission()
    {
        $billingInfo = new BinInfoModel();
        $billingInfo->setAlpha2('AF');
        $this->assertEquals(CommissionHelper::getCommission($billingInfo), 0.02);
    }
}
