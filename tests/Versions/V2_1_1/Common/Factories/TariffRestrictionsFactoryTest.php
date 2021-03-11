<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\TariffRestrictions;
use PHPUnit\Framework\TestCase;
use stdClass;

class TariffRestrictionsFactoryTest extends TestCase
{
    public static function assertTariffRestrictions(?stdClass $json, ?TariffRestrictions $tariffRestrictions): void
    {
        if($json === null){
            self::assertNull($tariffRestrictions);
        } else {
            self::assertSame($json->start_time ?? null, $tariffRestrictions->getStartTime());
            self::assertSame($json->end_time ?? null, $tariffRestrictions->getEndTime());
            self::assertSame($json->start_date ?? null, $tariffRestrictions->getStartDate());
            self::assertSame($json->end_date ?? null, $tariffRestrictions->getEndDate());
            self::assertSame((float)$json->min_kwh ?? null, $tariffRestrictions->getMinKwh());
            self::assertSame((float)$json->max_kwh ?? null, $tariffRestrictions->getMaxKwh());
            self::assertSame((float)$json->min_power ?? null, $tariffRestrictions->getMinPower());
            self::assertSame((float)$json->max_power ?? null, $tariffRestrictions->getMaxPower());
            self::assertSame((int)$json->min_duration ?? null, $tariffRestrictions->getMinDuration());
            self::assertSame((int)$json->max_duration ?? null, $tariffRestrictions->getMaxDuration());

            if (property_exists($json, 'day_of_week')) {
                foreach ($tariffRestrictions->getDaysOfWeek() as $index => $dayOfWeek) {
                    self::assertSame($json->day_of_week[$index], $dayOfWeek->getValue());
                }
            } else {
                self::assertNull($tariffRestrictions->getDaysOfWeek());
            }
        }
    }
}
