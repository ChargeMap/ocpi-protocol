<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\GeoLocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use JsonException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;

class GeoLocationFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/GeoLocation/Valid/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/GeoLocation/Valid/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws JsonException|InvalidPayloadException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        OcpiTestCase::coerce( realpath( __DIR__.'/../../../../../src/Versions/V2_1_1/Server/Emsp/Schemas/common.json' ). '#/definitions/geo_location', $json );

        $geolocation = GeoLocationFactory::fromJson($json);

        self::assertGeolocation($json, $geolocation);
    }

    public function getInvalidFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/GeoLocation/Invalid/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/GeoLocation/Invalid/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @dataProvider getInvalidFromJsonData()
     */
    public function testInvalidFromJson(string $payload): void
    {
        $this->expectException(InvalidPayloadException::class);

        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        OcpiTestCase::coerce( realpath( __DIR__.'/../../../../../src/Versions/V2_1_1/Server/Emsp/Schemas/common.json' ). '#/definitions/geo_location', $json );
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