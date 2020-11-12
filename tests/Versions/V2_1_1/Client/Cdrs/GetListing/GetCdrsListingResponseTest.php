<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing\GetCdrsListingRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing\GetCdrsListingResponse;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class GetCdrsListingResponseTest extends TestCase
{
    public function testWithDocumentationExamplePayload(): void
    {
        $payload = file_get_contents(__DIR__ . '/../payloads/cdr.json');

        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Total-Count', 1)
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream($payload)
            );

        // first item of list
        $cdr = GetCdrsListingResponse::from((new GetCdrsListingRequest())
            ->withOffset(0)
            ->withLimit(10), $serverResponse)
            ->getCdrs()[0];

        $this->assertSame($json->data[0]->id, $cdr->getId());
        $this->assertSame($json->data[0]->start_date_time, DateTimeFormatter::format($cdr->getStartDateTime()));
        $this->assertSame($json->data[0]->stop_date_time, DateTimeFormatter::format($cdr->getStopDateTime()));
        $this->assertSame($json->data[0]->auth_id, $cdr->getAuthId());
        $this->assertSame($json->data[0]->auth_method, $cdr->getAuthMethod()->getValue());
        $this->assertSame($json->data[0]->location->id, $cdr->getLocation()->getId());
        $this->assertSame($json->data[0]->currency, $cdr->getCurrency());
        $this->assertSame($json->data[0]->tariffs[0]->id, $cdr->getTariffs()[0]->getId());
        $this->assertSame($json->data[0]->charging_periods[0]->start_date_time, DateTimeFormatter::format($cdr->getChargingPeriods()[0]->getStartDate()));
        $this->assertSame($json->data[0]->total_cost, $cdr->getTotalCost());
        $this->assertSame($json->data[0]->total_energy, $cdr->getTotalEnergy());
        $this->assertSame($json->data[0]->total_time, $cdr->getTotalTime());
        $this->assertSame($json->data[0]->last_updated, DateTimeFormatter::format($cdr->getLastUpdated()));

    }

}
