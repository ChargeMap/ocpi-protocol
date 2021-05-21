<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\TariffRestrictions;
use PHPUnit\Framework\Assert;
use stdClass;

class TariffRestrictionsFactoryTest
{
    public static function assertTariffRestrictions(?stdClass $json, ?TariffRestrictions $tariffRestrictions): void
    {
        if($json === null){
            Assert::assertNull($tariffRestrictions);
        } else {
            Assert::assertSame($json->start_time ?? null, $tariffRestrictions->getStartTime());
            Assert::assertSame($json->end_time ?? null, $tariffRestrictions->getEndTime());
            Assert::assertSame($json->start_date ?? null, $tariffRestrictions->getStartDate());
            Assert::assertSame($json->end_date ?? null, $tariffRestrictions->getEndDate());
            Assert::assertSame(($json->min_kwh ?? null) === null ? null : (float)$json->min_kwh, $tariffRestrictions->getMinKwh());
            Assert::assertSame(($json->max_kwh ?? null) === null ? null : (float)$json->max_kwh, $tariffRestrictions->getMaxKwh());
            Assert::assertSame(($json->min_power ?? null) === null ? null : (float)$json->min_power, $tariffRestrictions->getMinPower());
            Assert::assertSame(($json->max_power ?? null) === null ? null : (float)$json->max_power, $tariffRestrictions->getMaxPower());
            Assert::assertSame(($json->min_duration ?? null) === null ? null : (int)$json->min_duration, $tariffRestrictions->getMinDuration());
            Assert::assertSame(($json->max_duration ?? null) === null ? null : (int)$json->max_duration, $tariffRestrictions->getMaxDuration());

            if (property_exists($json, 'day_of_week')) {
                foreach ($tariffRestrictions->getDaysOfWeek() as $index => $dayOfWeek) {
                    Assert::assertSame($json->day_of_week[$index], $dayOfWeek->getValue());
                }
            } else {
                Assert::assertNull($tariffRestrictions->getDaysOfWeek());
            }
        }
    }
}
