<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\TariffElement;
use PHPUnit\Framework\Assert;
use stdClass;

class TariffElementFactoryTest
{
    public static function assertTariffElement(?stdClass $json,?TariffElement $tariffElement):void
    {
        if($json === null){
            Assert::assertNull($tariffElement);
        } else {
            TariffRestrictionsFactoryTest::assertTariffRestrictions($json->restrictions ?? null,$tariffElement->getRestrictions());

            foreach ($tariffElement->getPriceComponents() as $index => $priceComponent){
                PriceComponentsFactoryTest::assertPriceComponents($json->price_components[$index],$priceComponent);
            }
        }
    }
}
