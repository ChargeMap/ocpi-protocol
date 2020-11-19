<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\GeoLocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class GeoLocationFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/GeoLocation') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/GeoLocation/' . $filename),
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

        $geolocation = GeoLocationFactory::fromJson($json);

        self::assertGeolocation($json, $geolocation);
    }

    public static function assertGeolocation(?stdClass $json, ?GeoLocation $geolocation): void
    {
        if($json === null) {
            Assert::assertNull($geolocation);
        } else {
            Assert::assertSame($json->latitude, $geolocation->getLatitude());
            Assert::assertSame($json->longitude, $geolocation->getLongitude());
        }
    }
}