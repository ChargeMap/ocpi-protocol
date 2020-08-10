<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Post;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Post\OcpiEmspCdrPostRequest;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithFullPayload(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/CdrFullPayload.json');

        $request = new OcpiEmspCdrPostRequest($serverRequestInterface);

        $cdr = $request->getCdr();
        $this->assertEquals('12345', $cdr->getId());
        $this->assertEquals(new DateTime('2015-06-29T21:39:09Z'), $cdr->getStartDateTime());
        $this->assertEquals(new DateTime('2015-06-29T23:37:32Z'), $cdr->getStopDateTime());
        $this->assertEquals('DE8ACC12E46L89', $cdr->getAuthId());
        $this->assertEquals('WHITELIST', $cdr->getAuthMethod());
        $this->assertEquals('LOC1', $cdr->getLocation()->getId());
        $this->assertEquals('EUR', $cdr->getCurrency());
        $this->assertCount(2, $cdr->getTariffs());

        $tariff = $cdr->getTariffs()[0];
        $this->assertEquals('12', $tariff->getId());
        $this->assertEquals('EUR', $tariff->getCurrency());
        $this->assertEquals(new DateTime('2015-02-02T14:15:01Z'), $tariff->getLastUpdated());
        $this->assertCount(1, $tariff->getTariffAltText());
        $this->assertEquals('https://google.com', $tariff->getTariffAltUrl());
        $this->assertCount(2, $tariff->getElements());

        $element = $tariff->getElements()[0];
        $this->assertCount(1, $element->getPriceComponents());

        $priceComponent = $element->getPriceComponents()[0];
        $this->assertEquals('TIME', $priceComponent->getType()->getValue());
        $this->assertEquals(2.00, $priceComponent->getPrice());
        $this->assertEquals(300, $priceComponent->getStepSize());

        $restrictions = $element->getRestrictions();
        $this->assertEquals('09:00', $restrictions->getStartTime());
        $this->assertEquals('20:00', $restrictions->getEndTime());
        $this->assertEquals('2020-01-09', $restrictions->getStartDate());
        $this->assertEquals('2020-02-09', $restrictions->getEndDate());
        $this->assertEquals(5.5, $restrictions->getMinKwh());
        $this->assertEquals(10.4, $restrictions->getMaxKwh());
        $this->assertEquals(3.3, $restrictions->getMinPower());
        $this->assertEquals(5.6, $restrictions->getMaxPower());
        $this->assertEquals(1, $restrictions->getMinDuration());
        $this->assertEquals(2, $restrictions->getMaxDuration());

        $this->assertCount(3, $restrictions->getDaysOfWeek());
        $day = $restrictions->getDaysOfWeek()[0];
        $this->assertEquals('MONDAY', $day->getValue());
    }

    public function testWithoutBody(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(""));

        $this->expectException(OcpiNotEnoughInformationClientError::class);
        new OcpiEmspCdrPostRequest($serverRequestInterface);
    }
}
