<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch\OcpiEmspLocationPatchRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch\UnsupportedPatchException;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialLocationFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch\OcpiEmspLocationPatchRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function validParametersProvider(): iterable
    {
        $validParams = [
            ['FR', 'TNM', 'LOC1'],
            ['FR', 'TNM', 'LOC1'],
            ['FR', 'TNM', 'LOC1']
        ];

        foreach (scandir(__DIR__ . '/payloads/') as $filename) {
            if (!is_dir(__DIR__ . '/payloads/' . $filename)) {
                foreach ($validParams as $index => $validParam) {
                    yield basename($filename, '.json') . "_$index" => [
                        __DIR__ . '/payloads/' . $filename,
                        ...$validParam
                    ];
                }
            }
        }
    }

    /**
     * @dataProvider validParametersProvider
     * @param string $filename
     * @param string $countryCode
     * @param string $partyId
     * @param string $locationId
     * @throws UnsupportedPatchException
     */
    public function testShouldConstructRequestWithFullPayload(string $filename, string $countryCode, string $partyId, string $locationId): void
    {
        $serverRequestInterface = $this->createServerRequestInterface($filename);

        $request = new OcpiEmspLocationPatchRequest($serverRequestInterface, new LocationRequestParams($countryCode, $partyId, $locationId));

        $this->assertSame($countryCode, $request->getCountryCode());
        $this->assertSame($partyId, $request->getPartyId());
        $this->assertSame($locationId, $request->getLocationId());

        $location = $request->getPartialLocation();

        PartialLocationFactoryTest::assertPartialLocation($request->getJsonBody(), $location);
    }

    public function testShouldFailWithPatchId(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/LocationPatchFullPayload.json');

        $this->expectException(UnsupportedPatchException::class);
        new OcpiEmspLocationPatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC2'));
    }
}
