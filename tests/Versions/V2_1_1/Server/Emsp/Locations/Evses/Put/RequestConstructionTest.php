<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Put;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Put\OcpiEmspEvsePutRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\EvseFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Put\OcpiEmspEvsePutRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructRequestWithPayload(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/EvsePutFullPayload.json');

        $request = new OcpiEmspEvsePutRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256'));
        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('TNM', $request->getPartyId());
        $this->assertEquals('LOC1', $request->getLocationId());
        $this->assertEquals('3256', $request->getEvseUid());

        $evse = $request->getEvse();
        EvseFactoryTest::assertEvse($request->getJsonBody(), $evse);
    }

    public function testShouldFailWithoutEvseId(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/EvsePutFullPayload.json');

        $this->expectException(OcpiNotEnoughInformationClientError::class);

        new OcpiEmspEvsePutRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1'));
    }
}
