<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnvironmentalImpact;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnvironmentalImpact
 */
class EnvironmentalImpactTest
{
    public static function assertJsonSerialization(?EnvironmentalImpact $environmentalImpact, ?stdClass $json)
    {
        if ($environmentalImpact === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($environmentalImpact->getSource()->getValue(), $json->source);
            Assert::assertSame($environmentalImpact->getAmount(), (float)$json->amount);
        }
    }
}
