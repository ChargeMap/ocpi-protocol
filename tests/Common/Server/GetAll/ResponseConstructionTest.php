<?php

namespace Tests\Chargemap\OCPI\Common\Server\GetAll;

use Chargemap\OCPI\Common\Server\GetAll\OcpiGetAllVersionsResponse;
use Chargemap\OCPI\Common\Server\Models\Version;
use Chargemap\OCPI\Common\Server\Models\VersionNumber;
use Error;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    public function testShouldFailWithoutVersions()
    {
        $response = new OcpiGetAllVersionsResponse('Message!');
        $this->expectException(Error::class);
        $response->getResponseInterface();
    }

    public function testShouldConstructWithVersion()
    {
        $response = new OcpiGetAllVersionsResponse('Message!');
        $response->addVersion(new Version(
            VersionNumber::VERSION_2_1_1(),
            'versionurl/2.1.1'
        ));
        $responseInterface = $response->getResponseInterface();
        $this->assertEquals([
            [
                'version' => VersionNumber::VERSION_2_1_1,
                'url' => 'versionurl/2.1.1',
            ]
        ], json_decode($responseInterface->getBody()->getContents(), true)['data']);
    }

    public function testShouldConstructWithMultipleVersions()
    {
        $response = new OcpiGetAllVersionsResponse('Message!');
        $response
            ->addVersion(new Version(
                VersionNumber::VERSION_2_1_1(),
                'versionurl/2.1.1'
            ))
            ->addVersion(new Version(
                VersionNumber::VERSION_2_0(),
                'versionurl/2.0'
            ));
        $responseInterface = $response->getResponseInterface();
        $this->assertEquals([
            [
                'version' => VersionNumber::VERSION_2_1_1,
                'url' => 'versionurl/2.1.1',
            ],
            [
                'version' => VersionNumber::VERSION_2_0,
                'url' => 'versionurl/2.0',
            ]
        ], json_decode($responseInterface->getBody()->getContents(), true)['data']);
    }
}
