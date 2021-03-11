<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Tariff;
use DateTime;
use PHPUnit\Framework\Assert;
use stdClass;

class TariffFactoryTest
{
    public static function assertTariff(?stdClass $json,?Tariff $tariff):void
    {
        if($json === null) {
            Assert::assertNull($tariff);
        } else {
            Assert::assertSame($json->id, $tariff->getId());
            Assert::assertSame($json->currency,$tariff->getCurrency());
            if (property_exists($json, 'tariff_alt_text')) {
                foreach ($tariff->getTariffAltText() as $index => $displayText){
                    DisplayTextFactoryTest::assertDisplayText($json->tariff_alt_text[$index],$displayText);
                }
            }
            Assert::assertSame($json->tariff_alt_url ?? null,$tariff->getTariffAltUrl());
            foreach ($tariff->getElements() as $index => $tariffElement){
                TariffElementFactoryTest::assertTariffElement($json->elements[$index],$tariffElement);
            }
            EnergyMixFactoryTest::assertEnergyMix($json->energy_mix ?? null,$tariff->getEnergyMix());
            Assert::assertEquals(new DateTime($json->last_updated), $tariff->getLastUpdated());
        }
    }
}
