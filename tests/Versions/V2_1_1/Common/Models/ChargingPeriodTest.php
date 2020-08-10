<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\ChargingPeriodFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CdrDimension;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CdrDimensionType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ChargingPeriod;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

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

        Assert::assertCount(1, $chargingPeriod->getCdrDimensions() );
        Assert::assertSame( 45., $chargingPeriod->getCdrDimension(CdrDimensionType::TIME())->getVolume() );

        // Now test overwriting the dimension
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::TIME(), 55.));

        Assert::assertCount(1, $chargingPeriod->getCdrDimensions() );
        Assert::assertSame( 55., $chargingPeriod->getCdrDimension(CdrDimensionType::TIME())->getVolume() );

        // Now test adding another dimension
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::ENERGY(), 25.));

        Assert::assertCount(2, $chargingPeriod->getCdrDimensions() );
        Assert::assertSame( 25., $chargingPeriod->getCdrDimension(CdrDimensionType::ENERGY())->getVolume() );
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
     * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\ChargingPeriod::jsonSerialize()
     */
    public function testJsonSerialize(stdClass $payload): void
    {
        $chargingPeriod = ChargingPeriodFactory::fromJson($payload);

        Assert::assertEquals( $payload, json_decode(json_encode($chargingPeriod)));
    }
}