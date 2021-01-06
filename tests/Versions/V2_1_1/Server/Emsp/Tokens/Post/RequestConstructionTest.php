<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Post;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\TokenType;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Post\OcpiEmspTokenPostRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\Assert;
use stdClass;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function validParametersProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/valid/') as $filename) {
            if( $filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [
                    'payload' => file_get_contents( __DIR__ . '/payloads/valid/' . $filename ),
                ];
            }
        }
    }

    public function invalidParametersProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/invalid/') as $filename) {
            if( $filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [
                    'payload' => file_get_contents(__DIR__ . '/payloads/invalid/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @dataProvider validParametersProvider()
     */
    public function testShouldConstructRequestWithPayload(string $payload): void
    {
        $json = null;

        $serverRequestInterface = Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withQueryParams(['type' => 'rfid'])
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');

        if (!empty($payload)) {
            $json = json_decode($payload);
            $serverRequestInterface = $serverRequestInterface->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));
        }

        $request = new OcpiEmspTokenPostRequest($serverRequestInterface, '4050933D');

        $this->assertEquals('4050933D', $request->getTokenId());
        $this->assertEquals(TokenType::RFID, $request->getTokenType()->getValue());

        self::assertLocationReferences($json, $request);
    }

    /**
     * @param string $payload
     * @dataProvider validParametersProvider()
     */
    public function testShouldConstructRequestWithOtherAuthenticationType(string $payload): void
    {
        $json = null;

        $serverRequestInterface = Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withQueryParams(['type' => 'other'])
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');

        if (!empty($payload)) {
            $json = json_decode($payload);
            $serverRequestInterface = $serverRequestInterface->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));
        }

        $request = new OcpiEmspTokenPostRequest($serverRequestInterface, '12345');

        $this->assertEquals('12345', $request->getTokenId());
        $this->assertEquals(TokenType::OTHER, $request->getTokenType()->getValue());

        self::assertLocationReferences($json, $request);
    }

    /**
     * @param string $payload
     * @dataProvider validParametersProvider()
     */
    public function testShouldConstructRequestWithoutAuthenticationType(string $payload): void
    {
        $json = null;

        $serverRequestInterface = Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');

        if (!empty($payload)) {
            $json = json_decode($payload);
            $serverRequestInterface = $serverRequestInterface->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));
        }

        $request = new OcpiEmspTokenPostRequest($serverRequestInterface, '12345');

        $this->assertEquals('12345', $request->getTokenId());
        $this->assertEquals(TokenType::RFID, $request->getTokenType()->getValue());

        self::assertLocationReferences($json, $request);
    }

    /**
     * @param string $payload
     * @dataProvider invalidParametersProvider()
     */
    public function testShouldFailWithInvalidArgument(string $payload): void
    {
        $this->expectException(OcpiInvalidPayloadClientError::class);

        $json = null;

        $serverRequestInterface = Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withQueryParams(['type' => 'rfid'])
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');

        if (!empty($payload)) {
            $json = json_decode($payload);
            $serverRequestInterface = $serverRequestInterface->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));
        }

        new OcpiEmspTokenPostRequest($serverRequestInterface, '4050933D');
    }

    public static function assertLocationReferences(?stdClass $json, OcpiEmspTokenPostRequest $request)
    {
        if($json !== null) {

            Assert::assertSame($json->location_id, $request->getLocationReferences()->getLocationId());

            if(isset($json->evse_uids)) {
                foreach($json->evse_uids as $index => $evseUid ) {
                    Assert::assertSame($json->evse_uids[$index], $request->getLocationReferences()->getEvseUids()[$index]);
                }
            } else {
                Assert::assertSame(0, count($request->getLocationReferences()->getEvseUids()));
            }

            if(isset($json->connector_ids)) {
                foreach($json->connector_ids as $index => $connectorId ) {
                    Assert::assertSame($json->connector_ids[$index], $request->getLocationReferences()->getConnectorIds()[$index]);
                }
            } else {
                Assert::assertSame(0, count($request->getLocationReferences()->getConnectorIds()));
            }

        } else {
            Assert::assertNull($request->getLocationReferences());
        }
    }
}
