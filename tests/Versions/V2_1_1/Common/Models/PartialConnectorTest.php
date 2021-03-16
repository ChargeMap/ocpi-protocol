<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialConnector;
use DateTime;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialConnector
 */
class PartialConnectorTest
{
    public static function assertJsonSerialization(?PartialConnector $connector, ?stdClass $json): void
    {
        if ($connector === null) {
            Assert::assertNull($json);
        } else {
            if ($connector->hasId()) {
                Assert::assertTrue(property_exists($json, 'id'));
                Assert::assertSame($connector->getId(), $json->id);
            } else {
                Assert::assertFalse(property_exists($json, 'id'));
            }
            if ($connector->hasStandard()) {
                Assert::assertTrue(property_exists($json, 'standard'));
                Assert::assertSame($connector->getStandard()->getValue(), $json->standard);
            } else {
                Assert::assertFalse(property_exists($json, 'standard'));
            }
            if ($connector->hasFormat()) {
                Assert::assertTrue(property_exists($json, 'format'));
                Assert::assertSame($connector->getFormat()->getValue(), $json->format);
            } else {
                Assert::assertFalse(property_exists($json, 'format'));
            }
            if ($connector->hasPowerType()) {
                Assert::assertTrue(property_exists($json, 'power_type'));
                Assert::assertSame($connector->getPowerType()->getValue(), $json->power_type);
            } else {
                Assert::assertFalse(property_exists($json, 'power_type'));
            }
            if ($connector->hasVoltage()) {
                Assert::assertTrue(property_exists($json, 'voltage'));
                Assert::assertSame($connector->getVoltage(), $json->voltage);
            } else {
                Assert::assertFalse(property_exists($json, 'voltage'));
            }
            if ($connector->hasAmperage()) {
                Assert::assertTrue(property_exists($json, 'amperage'));
                Assert::assertSame($connector->getAmperage(), $json->amperage);
            } else {
                Assert::assertFalse(property_exists($json, 'amperage'));
            }
            if ($connector->hasTariffId()) {
                Assert::assertTrue(property_exists($json, 'tariff_id'));
                Assert::assertSame($connector->getTariffId(), $json->tariff_id);
            } else {
                Assert::assertFalse(property_exists($json, 'tariff_id'));
            }
            if ($connector->hasTermsAndConditions()) {
                Assert::assertTrue(property_exists($json, 'terms_and_conditions'));
                Assert::assertSame($connector->getTermsAndConditions(), $json->terms_and_conditions);
            } else {
                Assert::assertFalse(property_exists($json, 'terms_and_conditions'));
            }
            if ($connector->hasLastUpdated()) {
                Assert::assertTrue(property_exists($json, 'last_updated'));
                Assert::assertEquals($connector->getLastUpdated(), new DateTime($json->last_updated));
            } else {
                Assert::assertFalse(property_exists($json, 'last_updated'));
            }
        }
    }
}
