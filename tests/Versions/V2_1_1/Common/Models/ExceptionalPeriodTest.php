<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ExceptionalPeriod;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\ExceptionalPeriod
 */
class ExceptionalPeriodTest
{
    public static function assertJsonSerialization(?ExceptionalPeriod $exceptionalPeriod, ?stdClass $json)
    {
        if ($exceptionalPeriod === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame(DateTimeFormatter::format($exceptionalPeriod->getPeriodBegin()), $json->period_begin);
            Assert::assertSame(DateTimeFormatter::format($exceptionalPeriod->getPeriodEnd()), $json->period_begin);
        }
    }
}
