<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Get\OcpiEmspLocationGetRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Get\OcpiEmspLocationGetRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $request = new OcpiEmspLocationGetRequest($serverRequestInterface, new LocationRequestParams('EN', 'PID', 'locationId'));
        $this->assertInstanceOf(OcpiEmspLocationGetRequest::class, $request);
        $this->assertEquals('EN', $request->getCountryCode());
        $this->assertEquals('PID', $request->getPartyId());
        $this->assertEquals('locationId', $request->getLocationId());
    }
}
