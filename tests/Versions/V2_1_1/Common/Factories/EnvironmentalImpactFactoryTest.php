<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\BusinessDetailsFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\EnvironmentalImpactFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\BusinessDetails;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnvironmentalImpact;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnvironmentalImpactCategory;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class EnvironmentalImpactFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/EnvironmentalImpact/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/EnvironmentalImpact/' . $filename),
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

        $environmentalImpact = EnvironmentalImpactFactory::fromJson($json);

        self::assertEnvironmentalImpact($json, $environmentalImpact);
    }

    public static function assertEnvironmentalImpact(?stdClass $json, ?EnvironmentalImpact $environmentalImpact): void
    {
        if($json === null) {
            Assert::assertNull($environmentalImpact);
        } else {
            Assert::assertEquals(new EnvironmentalImpactCategory($json->source), $environmentalImpact->getSource());
            Assert::assertSame($json->amount, $environmentalImpact->getAmount());
        }
    }
}