<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\BusinessDetails;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\BusinessDetails
 */
class BusinessDetailsTest
{
    public static function assertJsonSerialization(?BusinessDetails $businessDetails, ?stdClass $json): void
    {
        if ($businessDetails === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($businessDetails->getName(), $json->name);
            Assert::assertSame($businessDetails->getWebsite(), $json->website ?? null);
            ImageTest::assertJsonSerialization($businessDetails->getLogo(), $json->logo ?? null);
        }
    }
}
