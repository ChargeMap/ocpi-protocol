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
            Assert::assertSame((float)$json->min_kwh ?? null, $tariffRestrictions->getMinKwh());
            Assert::assertSame((float)$json->max_kwh ?? null, $tariffRestrictions->getMaxKwh());
            Assert::assertSame((float)$json->min_power ?? null, $tariffRestrictions->getMinPower());
            Assert::assertSame((float)$json->max_power ?? null, $tariffRestrictions->getMaxPower());
            Assert::assertSame((int)$json->min_duration ?? null, $tariffRestrictions->getMinDuration());
            Assert::assertSame((int)$json->max_duration ?? null, $tariffRestrictions->getMaxDuration());

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
