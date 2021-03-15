<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Connector;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\Connector
 */
class ConnectorTest
{
    public static function assertJsonSerialization(?Connector $connector, ?stdClass $json): void
    {
        if ($connector === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($connector->getId(), $json->id);
            Assert::assertSame($connector->getStandard()->getValue(), $json->standard);
            Assert::assertSame($connector->getFormat()->getValue(), $json->format);
            Assert::assertSame($connector->getPowerType()->getValue(), $json->power_type);
            Assert::assertSame($connector->getVoltage(), $json->voltage);
            Assert::assertSame($connector->getAmperage(), $json->amperage);
            Assert::assertSame($connector->getTariffId(), $json->tariff_id);
            Assert::assertSame($connector->getTermsAndConditions(), $json->terms_and_conditions);
            Assert::assertEquals(DateTimeFormatter::format($connector->getLastUpdated()), $json->last_updated);
        }
    }
}
