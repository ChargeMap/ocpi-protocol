<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialSessionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialSession;
use DateTime;
use JsonException;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialSessionFactory
 */
class PartialSessionFactoryTest extends FactoryTestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/PartialSession/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/PartialSession/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws JsonException|InvalidPayloadException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $this->coerce(realpath(__DIR__ . '/../../../../../src/Versions/V2_1_1/Server/Emsp/Schemas/sessionPatch.schema.json'), $json);

        $session = PartialSessionFactory::fromJson($json);

        self::assertPartialSession($json, $session);
    }

    public static function assertPartialSession($json, PartialSession $session): void
    {
        if (property_exists($json, 'id')) {
            self::assertTrue($session->hasId());
            self::assertSame($json->id, $session->getId());
        } else {
            self::assertFalse($session->hasId());
        }
        if (property_exists($json, 'start_datetime')) {
            self::assertTrue($session->hasStartDate());
            self::assertEquals(new DateTime($json->start_datetime), $session->getStartDate());
        } else {
            self::assertFalse($session->hasStartDate());
        }
        if (property_exists($json, 'end_datetime')) {
            self::assertTrue($session->hasEndDate());
            self::assertEquals(new DateTime($json->end_datetime), $session->getEndDate());
        } else {
            self::assertFalse($session->hasEndDate());
        }
        if (property_exists($json, 'kwh')) {
            self::assertTrue($session->hasKwh());
            self::assertSame((float)$json->kwh, $session->getKwh());
        } else {
            self::assertFalse($session->hasKwh());
        }
        if (property_exists($json, 'auth_id')) {
            self::assertTrue($session->hasAuthId());
            self::assertSame($json->auth_id, $session->getAuthId());
        } else {
            self::assertFalse($session->hasAuthId());
        }
        if (property_exists($json, 'auth_method')) {
            self::assertTrue($session->hasAuthMethod());
            self::assertEquals($json->auth_method, $session->getAuthMethod()->getValue());
        } else {
            self::assertFalse($session->hasAuthMethod());
        }
        if (property_exists($json, 'location')) {
            self::assertTrue($session->hasLocation());
            LocationFactoryTest::assertLocation($json->location, $session->getLocation());
        } else {
            self::assertFalse($session->hasLocation());
        }
        if (property_exists($json, 'meter_id')) {
            self::assertTrue($session->hasMeterId());
            self::assertSame($json->meter_id, $session->getMeterId());
        } else {
            self::assertFalse($session->hasMeterId());
        }
        if (property_exists($json, 'currency')) {
            self::assertTrue($session->hasCurrency());
            self::assertSame($json->currency, $session->getCurrency());
        } else {
            self::assertFalse($session->hasCurrency());
        }
        if (property_exists($json, 'charging_periods')) {
            self::assertTrue($session->hasChargingPeriods());
            self::assertCount(count($json->charging_periods ?? []), $session->getChargingPeriods());
        } else {
            self::assertFalse($session->hasChargingPeriods());
        }
        if (property_exists($json, 'total_cost')) {
            self::assertTrue($session->hasTotalCost());
            self::assertSame($json->total_cost, $session->getTotalCost());
        } else {
            self::assertFalse($session->hasTotalCost());
        }
        if (property_exists($json, 'status')) {
            self::assertTrue($session->hasStatus());
            self::assertSame($json->status, $session->getStatus()->getValue());
        } else {
            self::assertFalse($session->hasStatus());
        }
        if (property_exists($json, 'last_updated')) {
            self::assertTrue($session->hasLastUpdated());
            self::assertEquals(new DateTime($json->last_updated), $session->getLastUpdated());
        } else {
            self::assertFalse($session->hasLastUpdated());
        }
    }
}
