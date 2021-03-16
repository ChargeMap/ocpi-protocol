<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Post;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Post\OcpiEmspCdrPostRequest;
use Exception;
use Http\Discovery\Psr17FactoryDiscovery;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CdrFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Post\OcpiEmspCdrPostRequest
 */
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
        $serverRequestInterface = $this->createServerRequestInterface($filename);
        $request = new OcpiEmspCdrPostRequest($serverRequestInterface);

        $cdr = $request->getCdr();
        CdrFactoryTest::assertCdr($request->getJsonBody(), $cdr);
    }

    public function testWithoutBody(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(""));

        $this->expectException(OcpiNotEnoughInformationClientError::class);
        new OcpiEmspCdrPostRequest($serverRequestInterface);
    }
}
