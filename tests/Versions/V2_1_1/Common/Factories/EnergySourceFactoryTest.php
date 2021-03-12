<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\EnergySourceFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnergySource;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnergySourceCategory;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class EnergySourceFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/EnergySource/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/EnergySource/' . $filename),
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

        $energySource = EnergySourceFactory::fromJson($json);

        self::assertEnergySource($json, $energySource);
    }

    public static function assertEnergySource(?stdClass $json, ?EnergySource $energySource): void
    {
        if($json === null) {
            Assert::assertNull($energySource);
        } else {
            Assert::assertEquals(new EnergySourceCategory($json->source), $energySource->getSource());
            Assert::assertSame(floatval($json->percentage), $energySource->getPercentage());
        }
    }
}