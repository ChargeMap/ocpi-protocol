<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PriceComponent;
use PHPUnit\Framework\TestCase;
use stdClass;

class PriceComponentsFactoryTest extends TestCase
{
    public static function assertPriceComponents(StdClass $json, PriceComponent $priceComponent): void
    {
        self::assertSame($json->type, $priceComponent->getType()->getValue());
        self::assertSame((float)$json->price, $priceComponent->getPrice());
        self::assertSame((int)$json->step_size, $priceComponent->getStepSize());
    }
}
