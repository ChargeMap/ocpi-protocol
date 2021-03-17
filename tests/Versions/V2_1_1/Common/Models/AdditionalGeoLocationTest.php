<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AdditionalGeoLocation;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\AdditionalGeoLocation
 */
class AdditionalGeoLocationTest
{
    public static function assertJsonSerialization(?AdditionalGeoLocation $additionalGeoLocation, ?stdClass $json): void
    {
        if ($additionalGeoLocation === null) {
            Assert::assertNull($json);
        } else {
            GeoLocationTest::assertJsonSerialization($additionalGeoLocation->getGeoLocation(), $json);
            DisplayTextTest::assertJsonSerialization($additionalGeoLocation->getName(), $json->name);
        }
    }
}
