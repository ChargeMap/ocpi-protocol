<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialConnectorFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialConnector;
use DateTime;
use stdClass;

class PartialConnectorFactoryTest extends FactoryTestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/PartialConnector/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/PartialConnector/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws \JsonException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $this->coerce( realpath( __DIR__.'/../../../../../src/Versions/V2_1_1/Server/Emsp/Schemas/connectorPatch.schema.json' ), $json );

        $connector = PartialConnectorFactory::fromJson($json);

        self::assertPartialConnector($json, $connector);
    }

    public function assertPartialConnector(?stdClass $json, ?PartialConnector $connector)
    {
        if($json === null ) {
            self::assertNull($connector);
        } else {
            if (property_exists($json, 'id')) {
                self::assertTrue($connector->hasId());
                self::assertSame($json->id, $connector->getId());
            } else {
                self::assertFalse($connector->hasId());
            }
            if (property_exists($json, 'standard')) {
                self::assertTrue($connector->hasStandard());
                self::assertSame($json->standard, $connector->getStandard()->getValue());
            } else {
                self::assertFalse($connector->hasStandard());
            }
            if (property_exists($json, 'format')) {
                self::assertTrue($connector->hasFormat());
                self::assertSame($json->format, $connector->getFormat()->getValue());
            } else {
                self::assertFalse($connector->hasFormat());
            }
            if (property_exists($json, 'power_type')) {
                self::assertTrue($connector->hasPowerType());
                self::assertSame($json->power_type, $connector->getPowerType()->getValue());
            } else {
                self::assertFalse($connector->hasPowerType());
            }
            if (property_exists($json, 'voltage')) {
                self::assertTrue($connector->hasVoltage());
                self::assertSame($json->voltage, $connector->getVoltage());
            } else {
                self::assertFalse($connector->hasVoltage());
            }
            if (property_exists($json, 'amperage')) {
                self::assertTrue($connector->hasAmperage());
                self::assertSame($json->amperage, $connector->getAmperage());
            } else {
                self::assertFalse($connector->hasAmperage());
            }
            if (property_exists($json, 'tariff_id')) {
                self::assertTrue($connector->hasTariffId());
                self::assertSame($json->tariff_id, $connector->getTariffId());
            } else {
                self::assertFalse($connector->hasTariffId());
            }
            if (property_exists($json, 'terms_and_conditions')) {
                self::assertTrue($connector->hasTermsAndConditions());
                self::assertSame($json->terms_and_conditions, $connector->getTermsAndConditions());
            } else {
                self::assertFalse($connector->hasTermsAndConditions());
            }
            if (property_exists($json, 'last_updated')) {
                self::assertTrue($connector->hasLastUpdated());
                self::assertEquals(new DateTime($json->last_updated), $connector->getLastUpdated());
            } else {
                self::assertFalse($connector->hasLastUpdated());
            }
        }
    }
}
