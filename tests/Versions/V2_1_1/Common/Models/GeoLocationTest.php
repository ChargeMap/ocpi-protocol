<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation
 */
class GeoLocationTest
{
    public static function assertJsonSerialization(?GeoLocation $geolocation, ?stdClass $json): void
    {
        if ($geolocation === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($geolocation->getLatitude(), $json->latitude);
            Assert::assertSame($geolocation->getLongitude(), $json->longitude);
        }
    }
}
