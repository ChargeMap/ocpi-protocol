<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Put;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Put\OcpiEmspLocationPutRequest;
use JsonException;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Put\OcpiEmspLocationPutRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function validParametersProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/') as $filename) {
            if (substr($filename, 0, 3) === 'ok_') {
                yield basename(substr($filename, 3), '.json') => [__DIR__ . '/payloads/' . $filename];
            }
        }
    }

    /**
     * @dataProvider validParametersProvider
     * @param string $filename
     * @throws JsonException
     */
    public function testShouldConstructRequestWithPayload(string $filename): void
    {
        $payload = json_decode( file_get_contents($filename), false, 512, JSON_THROW_ON_ERROR );

        $serverRequestInterface = $this->createServerRequestInterface($filename);

        $request = new OcpiEmspLocationPutRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', $payload->id));

        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('TNM', $request->getPartyId());
        $this->assertEquals($payload->id, $request->getLocationId());

        $location = $request->getLocation();
        LocationFactoryTest::assertLocation($request->getJsonBody(), $location);
    }
}
