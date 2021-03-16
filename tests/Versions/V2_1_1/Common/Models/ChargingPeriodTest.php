<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\ChargingPeriodFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CdrDimension;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CdrDimensionType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ChargingPeriod;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\ChargingPeriod
 */
class ChargingPeriodTest extends TestCase
{
    /**
     * @return mixed[][]
     */
    public function getJsonSerializeData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/ChargingPeriods') as $file) {
            if ($file !== '.' && $file !== '..') {
                yield $file => [
                    'payload' => json_decode(file_get_contents(__DIR__ . '/Payloads/ChargingPeriods/' . $file)),
                ];
            }
        }
    }

    /**
     * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\ChargingPeriod::addDimension()
     */
    public function testAddDimension(): void
    {
        $chargingPeriod = new ChargingPeriod(new DateTime('2020-08-07 11:30:00'));

        // Simple dimension add
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::TIME(), 45.));

        Assert::assertCount(1, $chargingPeriod->getCdrDimensions());
        Assert::assertSame(45., $chargingPeriod->getCdrDimension(CdrDimensionType::TIME())->getVolume());

        // Now test overwriting the dimension
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::TIME(), 55.));

        Assert::assertCount(1, $chargingPeriod->getCdrDimensions());
        Assert::assertSame(55., $chargingPeriod->getCdrDimension(CdrDimensionType::TIME())->getVolume());

        // Now test adding another dimension
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::ENERGY(), 25.));

        Assert::assertCount(2, $chargingPeriod->getCdrDimensions());
        Assert::assertSame(25., $chargingPeriod->getCdrDimension(CdrDimensionType::ENERGY())->getVolume());
    }

    public function testGetDimension(): void
    {
        $chargingPeriod = new ChargingPeriod(new DateTime('2020-08-07 11:30:00'));

        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::TIME(), 45.));

        // Test for a set dimension
        Assert::assertNotNull($chargingPeriod->getCdrDimension(CdrDimensionType::TIME()));

        // Test for an unset dimension
        Assert::assertNull($chargingPeriod->getCdrDimension(CdrDimensionType::ENERGY()));
    }

    /**
     * @param stdClass $payload
     * @dataProvider getJsonSerializeData()
     */
    public function testJsonSerialize(stdClass $payload): void
    {
        $chargingPeriod = ChargingPeriodFactory::fromJson($payload);

        self::assertJsonSerialization($chargingPeriod, $payload);
    }

    public static function assertJsonSerialization(?ChargingPeriod $chargingPeriod, ?stdClass $json): void
    {
        if ($chargingPeriod === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertEquals(DateTimeFormatter::format($chargingPeriod->getStartDate()), $json->start_date_time);
            Assert::assertSame(count($chargingPeriod->getCdrDimensions()), count($json->dimensions));
            foreach ($chargingPeriod->getCdrDimensions() as $index => $dimension) {
                CdrDimensionTest::assertJsonSerialization($dimension, $json->dimensions[$index],);
            }
        }
    }
}