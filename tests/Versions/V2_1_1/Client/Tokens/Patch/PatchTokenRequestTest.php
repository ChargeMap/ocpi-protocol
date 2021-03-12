<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialTokenFactory;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch\PatchTokenRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;

class PatchTokenRequestTest extends TestCase
{
    public function validParametersProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/') as $filename) {
            if (!is_dir(__DIR__ . '/payloads/' . $filename)) {
                yield basename($filename, '.json') => ['EN', 'CMP', '012345678', __DIR__ . '/payloads/' . $filename];
            }
        }
        yield ['FR', 'CMP', '012345678', __DIR__ . '/payloads/entire_token.json'];
        yield ['EN', 'CMP', '012345678012345678', __DIR__ . '/payloads/entire_token.json'];
    }

    /**
     * @dataProvider validParametersProvider
     * @param string $countryCode
     * @param string $partyId
     * @param string $tokenUid
     * @param string $filename
     * @throws InvalidPayloadException
     */
    public function testShouldConstructCorrectQuery(
        string $countryCode,
        string $partyId,
        string $tokenUid,
        string $filename
    ): void {
        $payload = json_decode(file_get_contents($filename));
        $partialToken = PartialTokenFactory::fromJson($payload);
        $request = new PatchTokenRequest($countryCode, $partyId, $tokenUid, $partialToken);
        $requestInterface = $request->getServerRequestInterface(
            Psr17FactoryDiscovery::findServerRequestFactory(),
            null
        );

        $this->assertSame("/$countryCode/$partyId/$tokenUid", $requestInterface->getUri()->getPath());
        $this->assertSame('PATCH', $requestInterface->getMethod());
        $requestBody = json_decode($requestInterface->getBody()->getContents());
        $this->assertEquals($payload, $requestBody);
        $schemaPath = __DIR__ . '/../../../../../../src/Versions/V2_1_1/Client/Tokens/Patch/tokenPatch.schema.json';
        OcpiTestCase::coerce($schemaPath, $requestBody);
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
        $payload = file_get_contents(__DIR__ . '/payloads/part_of_token.json');
        $token = PartialTokenFactory::fromJson(json_decode($payload));

        $this->expectException(InvalidArgumentException::class);
        new PatchTokenRequest($countryCode, $partyId, $tokenUid, $token);
    }
}