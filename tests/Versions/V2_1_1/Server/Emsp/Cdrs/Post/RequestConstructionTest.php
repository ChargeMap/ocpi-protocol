<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Post;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Post\OcpiEmspCdrPostRequest;
use DateTime;
use Exception;
use Http\Discovery\Psr17FactoryDiscovery;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function validPayloadsProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/') as $filename) {
            if (substr($filename, 0, 3) === 'ok_') {
                yield basename(substr($filename, 3), '.json') => [__DIR__ . '/payloads/' . $filename];
            }
        }
    }

    /**
     * @dataProvider validPayloadsProvider
     * @param string $filename
     * @throws Exception
     */
    public function testShouldConstructWithPayload(string $filename): void
    {
        $json = json_decode(file_get_contents($filename));
        $serverRequestInterface = $this->createServerRequestInterface($filename);

        $request = new OcpiEmspCdrPostRequest($serverRequestInterface);

        $cdr = $request->getCdr();
        $this->assertEquals($json->id, $cdr->getId());
        $this->assertEquals(new DateTime($json->start_date_time), $cdr->getStartDateTime());
        $this->assertEquals(new DateTime($json->stop_date_time), $cdr->getStopDateTime());
        $this->assertEquals($json->auth_id, $cdr->getAuthId());
        $this->assertEquals($json->auth_method, $cdr->getAuthMethod());
        $this->assertEquals($json->location->id, $cdr->getLocation()->getId());
        $this->assertEquals($json->currency, $cdr->getCurrency());

        if (isset($json->tariffs)) {

            $this->assertCount(count($json->tariffs), $cdr->getTariffs());

            foreach( $json->tariffs as $tariffIndex => $jsonTariff) {
                $tariff = $cdr->getTariffs()[$tariffIndex];
                $this->assertEquals($jsonTariff->id, $tariff->getId());
                $this->assertEquals($jsonTariff->currency, $tariff->getCurrency());
                $this->assertEquals(new DateTime($jsonTariff->last_updated), $tariff->getLastUpdated());
                $this->assertCount(count($jsonTariff->tariff_alt_text ?? []), $tariff->getTariffAltText());
                $this->assertEquals($jsonTariff->tariff_alt_url ?? null, $tariff->getTariffAltUrl());

                $this->assertCount(count($jsonTariff->elements), $tariff->getElements());

                foreach($jsonTariff->elements as $elementIndex => $jsonElement) {

                    $element = $tariff->getElements()[$elementIndex];
                    $this->assertCount(count($jsonElement->price_components), $element->getPriceComponents());

                    foreach($jsonElement->price_components as $priceComponentIndex => $jsonPriceComponent) {
                        $priceComponent = $element->getPriceComponents()[$priceComponentIndex];
                        $this->assertEquals($jsonPriceComponent->type, $priceComponent->getType()->getValue());
                        $this->assertEquals($jsonPriceComponent->price, $priceComponent->getPrice());
                        $this->assertEquals($jsonPriceComponent->step_size, $priceComponent->getStepSize());
                    }

                    $jsonRestrictions = $jsonElement->restrictions ?? null;

                    if ($jsonRestrictions !== null) {
                        $restrictions = $element->getRestrictions();
                        $this->assertEquals($jsonRestrictions->start_time ?? null, $restrictions->getStartTime());
                        $this->assertEquals($jsonRestrictions->end_time ?? null, $restrictions->getEndTime());
                        $this->assertEquals($jsonRestrictions->start_date ?? null, $restrictions->getStartDate());
                        $this->assertEquals($jsonRestrictions->end_date ?? null, $restrictions->getEndDate());
                        $this->assertEquals($jsonRestrictions->min_kwh ?? null, $restrictions->getMinKwh());
                        $this->assertEquals($jsonRestrictions->max_kwh ?? null, $restrictions->getMaxKwh());
                        $this->assertEquals($jsonRestrictions->min_power ?? null, $restrictions->getMinPower());
                        $this->assertEquals($jsonRestrictions->max_power ?? null, $restrictions->getMaxPower());
                        $this->assertEquals($jsonRestrictions->min_duration ?? null, $restrictions->getMinDuration());
                        $this->assertEquals($jsonRestrictions->max_duration ?? null, $restrictions->getMaxDuration());
                        $this->assertCount(count($jsonRestrictions->day_of_week ?? []), $restrictions->getDaysOfWeek());

                        $jsonDay = $jsonRestrictions->day_of_week[0];
                        $day = $restrictions->getDaysOfWeek()[0];
                        $this->assertEquals($jsonDay, $day->getValue());
                    } else {
                        $this->assertNull($element->getRestrictions());
                    }
                }
            }
        } else {
            $this->assertCount(0, $cdr->getTariffs());
        }
    }

    public function testWithoutBody(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(""));

        $this->expectException(OcpiNotEnoughInformationClientError::class);
        new OcpiEmspCdrPostRequest($serverRequestInterface);
    }
}
