<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Versions\Details\Get;

use Chargemap\OCPI\Common\Server\Models\VersionNumber;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Versions\Details\Get\OcpiEmspVersionDetailsGetResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Endpoint;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ModuleId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    public function testShouldFailWithoutEndpoints()
    {
        $response = new OcpiEmspVersionDetailsGetResponse(VersionNumber::VERSION_2_1_1(), 'Message!');

        $this->expectException(InvalidArgumentException::class);
        $response->getResponseInterface();
    }

    public function testShouldConstructWithEndpoint()
    {
        $response = new OcpiEmspVersionDetailsGetResponse(VersionNumber::VERSION_2_1_1(), 'Message!');
        $response->addEndpoint(new Endpoint(
            ModuleId::CDRS(),
            'versionurl/2.1.1/cdrs'
        ));
        $responseInterface = $response->getResponseInterface();
        $this->assertEquals([
            'version' => VersionNumber::VERSION_2_1_1,
            'endpoints' => [
                [
                    'identifier' => ModuleId::CDRS(),
                    'url' => 'versionurl/2.1.1/cdrs'
                ]
            ]
        ], json_decode($responseInterface->getBody()->getContents(), true)['data']);
    }

    public function testShouldConstructWithMultipleEndpoints()
    {
        $response = new OcpiEmspVersionDetailsGetResponse(VersionNumber::VERSION_2_1_1(), 'Message!');
        $response
            ->addEndpoint(new Endpoint(
                ModuleId::CDRS(),
                'versionurl/2.1.1/cdrs'
            ))->addEndpoint(new Endpoint(
                ModuleId::CRED_AND_REG(),
                'versionurl/2.1.1/credentials'
            ));
        $responseInterface = $response->getResponseInterface();
        $this->assertEquals([
            'version' => VersionNumber::VERSION_2_1_1,
            'endpoints' => [
                [
                    'identifier' => ModuleId::CDRS(),
                    'url' => 'versionurl/2.1.1/cdrs'
                ],
                [
                    'identifier' => ModuleId::CRED_AND_REG(),
                    'url' => 'versionurl/2.1.1/credentials'
                ]
            ]
        ], json_decode($responseInterface->getBody()->getContents(), true)['data']);
    }
}
