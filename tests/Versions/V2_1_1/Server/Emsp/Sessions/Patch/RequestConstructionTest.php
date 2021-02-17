<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch\UnsupportedPatchException;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Patch\OcpiEmspSessionPatchRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialSessionFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Patch\OcpiEmspSessionPatchRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function validParametersProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [
                    'filename' => __DIR__ . '/payloads/' . $filename
                ];
            }
        }
    }

    /**
     * @param string $filename
     * @dataProvider validParametersProvider()
     * @throws UnsupportedPatchException
     */
    public function testShouldConstructRequestWithPayload(string $filename): void
    {
        $serverRequestInterface = $this->createServerRequestInterface($filename);
        $json = json_decode(file_get_contents($filename));
        $request = new OcpiEmspSessionPatchRequest($serverRequestInterface, 'FR', 'TNM', $json->id ?? 'Default');

        PartialSessionFactoryTest::assertPartialSession($json, $request->getPartialSession());
    }

    public function testShouldFailWithPatchId(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/SessionPatchFullPayload.json');

        $this->expectException(UnsupportedPatchException::class);
        new OcpiEmspSessionPatchRequest($serverRequestInterface, 'FR', 'TNM', '102');
    }
}
