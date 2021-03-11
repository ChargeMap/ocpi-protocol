<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PriceComponent;
use PHPUnit\Framework\Assert;
use stdClass;

class PriceComponentsFactoryTest
{
    public static function assertPriceComponents(StdClass $json, PriceComponent $priceComponent): void
    {
        Assert::assertSame($json->type, $priceComponent->getType()->getValue());
        Assert::assertSame((float)$json->price, $priceComponent->getPrice());
        Assert::assertSame((int)$json->step_size, $priceComponent->getStepSize());
    }
}
