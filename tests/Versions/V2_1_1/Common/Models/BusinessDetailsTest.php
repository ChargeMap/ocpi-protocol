<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\BusinessDetails;
use PHPUnit\Framework\Assert;
use stdClass;

class BusinessDetailsTest
{
    public static function assertJsonSerialize(?BusinessDetails $businessDetails, ?stdClass $json): void
    {
        if ($businessDetails === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($businessDetails->getName(), $json->name);
            Assert::assertSame($businessDetails->getWebsite(), $json->website);
            ImageTest::assertJsonSerialize($businessDetails->getLogo(), $json->logo);
        }
    }
}
