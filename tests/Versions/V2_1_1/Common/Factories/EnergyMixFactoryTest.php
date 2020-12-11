<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\EnergyMixFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\EnvironmentalImpactFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnergyMix;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class EnergyMixFactoryTest extends FactoryTestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/EnergyMix/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/EnergyMix/' . $filename),
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

        $energyMix = EnergyMixFactory::fromJson($json);

        self::assertEnergyMix($json, $energyMix);
    }

    public static function assertEnergyMix(?stdClass $json, ?EnergyMix $energyMix): void
    {
        if($json === null) {
            Assert::assertNull($energyMix);
        } else {
            Assert::assertSame($json->is_green_energy, $energyMix->isGreenEnergy());
            Assert::assertSame($json->supplier_name ?? null, $energyMix->getSupplierName());
            Assert::assertSame($json->energy_product_name ?? null, $energyMix->getEnergyProductName());


            if(!property_exists($json, 'energy_sources') || $json->energy_sources === null) {
                Assert::assertCount(0, $energyMix->getEnergySources());
            } else {
                foreach ($json->energy_sources as $index => $energySource) {
                    EnergySourceFactoryTest::assertEnergySource($energySource, $energyMix->getEnergySources()[$index]);
                }
            }

            if(!property_exists($json, 'environ_impact') || $json->environ_impact === null) {
                Assert::assertCount(0, $energyMix->getEnvironImpact());
            } else {
                foreach ($json->environ_impact as $index => $environmentalImpact) {
                    EnvironmentalImpactFactoryTest::assertEnvironmentalImpact($environmentalImpact, $energyMix->getEnvironImpact()[$index]);
                }
            }
        }
    }
}