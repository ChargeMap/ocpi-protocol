<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Patch\OcpiEmspEvsePatchRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch\UnsupportedPatchException;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialEVSEFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Patch\OcpiEmspEvsePatchRequest
 */
class RequestConstructionTest extends OcpiTestCase
{

    public function getJsonFilename(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads') as $file) {
            if ($file !== '.' && $file !== '..') {
                yield $file => [
                    'payload' => __DIR__ . '/payloads/' . $file
                ];
            }
        }
    }

    /**
     * @param string $filename
     * @dataProvider getJsonFilename
     * @throws UnsupportedPatchException
     */
    public function testShouldConstructRequest(string $filename): void
    {
        $serverRequestInterface = $this->createServerRequestInterface($filename);
        $json = json_decode(file_get_contents($filename));

        $uid = $json->uid ?? '3256';

        $request = new OcpiEmspEvsePatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', $uid));

        $this->assertSame('FR', $request->getCountryCode());
        $this->assertSame('TNM', $request->getPartyId());
        $this->assertSame('LOC1', $request->getLocationId());
        $this->assertSame($uid, $request->getEvseUid());

        $evse = $request->getPartialEvse();
        PartialEVSEFactoryTest::assertPartialEVSE($request->getJsonBody(), $evse);
    }

    public function testShouldFailWithPatchUid(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/EvsePatchFullPayload.json');

        $this->expectException(UnsupportedPatchException::class);
        new OcpiEmspEvsePatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '1'));
    }
}
