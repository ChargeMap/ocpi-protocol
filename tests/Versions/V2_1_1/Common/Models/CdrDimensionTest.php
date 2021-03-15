<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CdrDimension;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\CdrDimension
 */
class CdrDimensionTest
{
    public static function assertJsonSerialization(?CdrDimension $cdrDimension, ?stdClass $json): void
    {
        if ($cdrDimension === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($cdrDimension->getType()->getValue(), $json->type);
            Assert::assertSame($cdrDimension->getVolume(), (float)$json->volume);
        }
    }
}
