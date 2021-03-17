<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\RegularHours;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\RegularHours
 */
class RegularHoursTest
{
    public static function assertJsonSerialization(?RegularHours $regularHour, ?stdClass $json)
    {
        if ($regularHour === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($regularHour->getPeriodBegin(), $json->period_begin);
            Assert::assertSame($regularHour->getPeriodEnd(), $json->period_end);
            Assert::assertSame($regularHour->getWeekday()->getValue(), $json->weekday);
        }
    }
}
