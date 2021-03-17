<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnergyMix;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnergyMix
 */
class EnergyMixTest
{
    public static function assertJsonSerialization(?EnergyMix $energyMix, ?stdClass $json): void
    {
        if ($energyMix === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($energyMix->isGreenEnergy(), $json->is_green_energy);
            Assert::assertSame($energyMix->getSupplierName(), $json->supplier_name);
            Assert::assertSame($energyMix->getEnergyProductName(), $json->energy_product_name);

            if (empty($energyMix->getEnergySources())) {
                Assert::assertEmpty($json->energy_sources);
            } else {
                foreach ($energyMix->getEnergySources() as $index => $energySource) {
                    EnergySourceTest::assertJsonSerialization($energySource, $json->energy_sources[$index]);
                }
            }

            if (empty($energyMix->getEnvironImpact())) {
                Assert::assertEmpty($json->environ_impact);
            } else {
                foreach ($energyMix->getEnvironImpact() as $index => $environmentalImpact) {
                    EnvironmentalImpactTest::assertJsonSerialization($environmentalImpact, $json->environ_impact[$index]);
                }
            }
        }
    }
}
