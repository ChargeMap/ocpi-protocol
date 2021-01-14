<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CdrFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AuthenticationMethod;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Cdr;
use DateTime;
use PHPUnit\Framework\Assert;
use stdClass;

class CdrFactoryTest extends FactoryTestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/Cdr/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/Cdr/' . $filename),
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

        $this->coerce( realpath( __DIR__.'/../../../../../src/Versions/V2_1_1/Server/Emsp/Schemas/cdrPost.schema.json' ), $json );

        $cdr = CdrFactory::fromJson($json);

        self::assertCdr($json, $cdr);
    }

    public static function assertCdr(?stdClass $json, ?Cdr $cdr): void
    {
        if($json === null) {
            Assert::assertNull($cdr);
        } else {
            Assert::assertSame($json->id, $cdr->getId());
            Assert::assertEquals(new DateTime($json->last_updated), $cdr->getLastUpdated());
            Assert::assertSame($json->auth_id, $cdr->getAuthId());
            Assert::assertEquals(new AuthenticationMethod($json->auth_method), $cdr->getAuthMethod());

            Assert::assertSame(count($json->charging_periods),count($cdr->getChargingPeriods()));

            foreach($cdr->getChargingPeriods() as $index => $chargingPeriod) {
                ChargingPeriodFactoryTest::assertChargingPeriod($json->charging_periods[$index], $chargingPeriod);
            }

            Assert::assertSame($json->currency, $cdr->getCurrency());
            LocationFactoryTest::assertLocation($json->location, $cdr->getLocation());
            Assert::assertSame($json->meter_id ?? null, $cdr->getMeterId());
            Assert::assertSame($json->remark ?? null, $cdr->getRemark());
            Assert::assertEquals(new DateTime($json->start_date_time), $cdr->getStartDateTime());
            Assert::assertEquals(new DateTime($json->stop_date_time), $cdr->getStopDateTime());
            Assert::assertSame((float)$json->total_cost, $cdr->getTotalCost());
            Assert::assertSame($json->total_energy, $cdr->getTotalEnergy());
            Assert::assertSame($json->total_parking_time ?? null, $cdr->getTotalParkingTime());
            Assert::assertSame($json->total_time, $cdr->getTotalTime());
        }
    }
}