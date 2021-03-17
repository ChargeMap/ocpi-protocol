<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Hours;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\Hours
 */
class HoursTest
{
    public static function assertJsonSerialization(?Hours $hours, ?stdClass $json): void
    {
        if ($hours === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($hours->isTwentyFourSeven(), $json->twentyfourseven ?? false);

            if (empty($hours->getRegularHours())) {
                Assert::assertEmpty($json->regular_hours);
            } else {
                foreach ($hours->getRegularHours() as $index => $regularHour) {
                    RegularHoursTest::assertJsonSerialization($regularHour, $json->regular_hours[$index]);
                }
            }

            if (empty($hours->getExceptionalOpenings())) {
                Assert::assertEmpty($json->exceptional_openings);
            } else {
                foreach ($hours->getExceptionalOpenings() as $index => $exceptionalPeriod) {
                    ExceptionalPeriodTest::assertJsonSerialization($exceptionalPeriod, $json->exceptional_openings[$index]);
                }
            }

            if (empty($hours->getExceptionalClosings())) {
                Assert::assertEmpty($json->exceptional_closings);
            } else {
                foreach ($hours->getExceptionalClosings() as $index => $exceptionalPeriod) {
                    ExceptionalPeriodTest::assertJsonSerialization($exceptionalPeriod, $json->exceptional_closings[$index]);
                }
            }
        }
    }
}
