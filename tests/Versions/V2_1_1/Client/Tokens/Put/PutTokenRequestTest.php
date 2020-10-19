<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Put;

use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Put\PutTokenRequest;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\TokenFactory;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PutTokenRequestTest extends TestCase
{
    public function validParametersProvider(): iterable
    {
        yield ['EN', 'CMP', '012345678'];
        yield ['FR', 'CMP', '012345678'];
        yield ['EN', 'CMP', '012345678012345678'];
    }

    /**
     * @dataProvider validParametersProvider
     * @param string $countryCode
     * @param string $partyId
     * @param string $tokenUid
     */
    public function testShouldConstructCorrectQuery(string $countryCode, string $partyId, string $tokenUid): void
    {
        $payload = json_decode(file_get_contents(__DIR__ . '/payloads/token.json'));
        $token = TokenFactory::fromJson($payload);
        $request = new PutTokenRequest($countryCode, $partyId, $tokenUid, $token);
        $requestInterface = $request->getServerRequestInterface(
            Psr17FactoryDiscovery::findServerRequestFactory(),
            null
        );
        $this->assertSame("/$countryCode/$partyId/$tokenUid", $requestInterface->getUri()->getPath());
        $this->assertSame('PUT', $requestInterface->getMethod());
        $this->assertEquals($payload, json_decode($requestInterface->getBody()->getContents()));
    }

    public function invalidParametersProvider(): iterable
    {
        yield 'Country code is empty' => ['', 'CMP', '012345678'];
        yield 'Country code is too short' => ['F', 'CMP', '012345678'];
        yield 'Country code is too long' => ['FRA', 'CMP', '012345678'];
        yield 'Party id is empty' => ['FR', '', '012345678'];
        yield 'Party id is too short' => ['EN', 'C', '012345678'];
        yield 'Party id is short' => ['EN', 'CM', '012345678'];
        yield 'Party id is too long' => ['EN', 'CMPR', '012345678'];
        yield 'Token uid is empty' => ['EN', 'CMP', ''];
        yield 'Token uid is too long' => ['EN', 'CMP', '0123456780123456780123456780123456780123'];
    }

    /**
     * @dataProvider invalidParametersProvider
     * @param string $countryCode
     * @param string $partyId
     * @param string $tokenUid
     */
    public function testShouldThrowExceptionWithInvalidParameters(
        string $countryCode,
        string $partyId,
        string $tokenUid
    ): void {
        $payload = file_get_contents(__DIR__ . '/payloads/token.json');
        $token = TokenFactory::fromJson(json_decode($payload));
        $this->expectException(InvalidArgumentException::class);
        new PutTokenRequest($countryCode, $partyId, $tokenUid, $token);
    }
}
