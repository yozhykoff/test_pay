<?php

namespace Helpers;

use App\Helpers\RoundHelper;
use PHPUnit\Framework\TestCase;

#[CoversClass(RoundHelper::class)]
class RoundHelperTest extends TestCase
{
    #[CoversFunction('ceilAmount')]
    public function testCeilAmount()
    {
        $this->assertEquals(RoundHelper::ceilAmount(0.46180), 0.47);
    }
}
