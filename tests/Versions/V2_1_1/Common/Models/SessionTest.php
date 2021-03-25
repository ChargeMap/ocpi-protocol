<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session
 */
class SessionTest
{
    public static function assertJsonSerialization(?Session $session, ?stdClass $json): void
    {
        if ($session === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($session->getId(), $json->id);

            if( is_null( $json->start_datetime ?? null ) ) {
                Assert::assertNull( $session->getStartDate() );
            } else {
                Assert::assertSame(DateTimeFormatter::format($session->getStartDate()), $json->start_datetime);
            }

            if( is_null( $json->end_datetime ?? null ) ) {
                Assert::assertNull( $session->getEndDate());
            } else {
                Assert::assertSame(DateTimeFormatter::format($session->getEndDate()), $json->end_datetime);
            }

            Assert::assertEquals($session->getKwh(), $json->kwh);
            Assert::assertSame($session->getAuthId(), $json->auth_id);
            Assert::assertSame($session->getAuthMethod()->getValue(), $json->auth_method);
            LocationTest::assertJsonSerialization($session->getLocation(), $json->location);
            Assert::assertSame($session->getMeterId(), $json->meter_id);
            Assert::assertSame($session->getCurrency(), $json->currency);
            Assert::assertCount(count($session->getChargingPeriods()), $json->charging_periods);
            foreach ($session->getChargingPeriods() as $index => $chargingPeriod) {
                ChargingPeriodTest::assertJsonSerialization($chargingPeriod, $json->charging_periods[$index]);
            }
            Assert::assertEquals($session->getTotalCost(), $json->total_cost);
            Assert::assertSame($session->getStatus()->getValue(), $json->status);
            Assert::assertSame(DateTimeFormatter::format($session->getLastUpdated()), $json->last_updated);
        }
    }
}
