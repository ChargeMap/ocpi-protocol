<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Put;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Put\OcpiEmspCredentialsPutRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CredentialsFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Put\OcpiEmspCredentialsPutRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function validPayloadsProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/valid/') as $filename) {
            if (!is_dir(__DIR__ . '/payloads/valid/' . $filename)) {
                yield basename($filename, '.json') => [__DIR__ . '/payloads/valid/' . $filename];
            }
        }
    }

    /**
     * @dataProvider validPayloadsProvider
     * @param string $filename
     */
    public function testShouldConstructWithPayload(string $filename): void
    {
        $serverRequestInterface = $this->createServerRequestInterface($filename);

        $request = new OcpiEmspCredentialsPutRequest($serverRequestInterface);

        CredentialsFactoryTest::assertCredentials($request->getJsonBody(), $request->getCredentials());
    }
}
