<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\AdditionalGeoLocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AdditionalGeoLocation;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class AdditionalGeoLocationFactoryTest extends FactoryTestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/AdditionalGeoLocation/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/AdditionalGeoLocation/' . $filename),
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

        $businessDetails = AdditionalGeoLocationFactory::fromJson($json);

        self::assertAdditionalGeoLocation($json, $businessDetails);
    }

    public static function assertAdditionalGeoLocation(?stdClass $json, ?AdditionalGeoLocation $additionalGeoLocation): void
    {
        if($json === null) {
            Assert::assertNull($additionalGeoLocation);
        } else {
            GeoLocationFactoryTest::assertGeolocation($json, $additionalGeoLocation->getGeoLocation());
            DisplayTextFactoryTest::assertDisplayText($json->name, $additionalGeoLocation->getName());
        }
    }
}