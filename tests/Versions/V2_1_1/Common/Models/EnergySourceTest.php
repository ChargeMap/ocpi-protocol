<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnergySource;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnergySource
 */
class EnergySourceTest
{
    public static function assertJsonSerialization(?EnergySource $energySource, ?stdClass $json)
    {
        if ($energySource === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($energySource->getSource()->getValue(), $json->source);
            Assert::assertSame($energySource->getPercentage(), (float)$json->percentage);
        }
    }
}
