<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\ChargingPeriodFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ChargingPeriod;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class ChargingPeriodFactoryTest extends FactoryTestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/ChargingPeriod/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/ChargingPeriod/' . $filename),
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

        $chargingPeriod = ChargingPeriodFactory::fromJson($json);

        self::assertChargingPeriod($json, $chargingPeriod);
    }

    public static function assertChargingPeriod(?stdClass $json, ?ChargingPeriod $chargingPeriod)
    {
        if($json === null) {
            Assert::assertNull($chargingPeriod);
        } else {

            // TODO Remap charging period getStartDate() to getStartDateTime() to be consistent
            Assert::assertEquals(new DateTime($json->start_date_time), $chargingPeriod->getStartDate());

            // TODO Remap charging period getCdrDimensions() to getDimensions() to be consistent
            Assert::assertSame(count($json->dimensions), count($chargingPeriod->getCdrDimensions()));

            foreach($chargingPeriod->getCdrDimensions() as $index => $dimension) {
                CdrDimensionFactoryTest::assertCdrDimension($json->dimensions[$index], $dimension);
            }
        }
    }
}