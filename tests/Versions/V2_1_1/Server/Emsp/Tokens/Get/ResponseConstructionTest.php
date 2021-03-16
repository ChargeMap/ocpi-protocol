<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\TokenFactory;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get\OcpiEmspTokenGetRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get\OcpiEmspTokenGetResponse;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models\TokenTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get\OcpiEmspTokenGetResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testShouldReturnEmptyArrayWithoutTokens(): void
    {
        $response = new OcpiEmspTokenGetResponse(self::getRequest(), 0, 10);
        $responseInterface = $response->getResponseInterface();
        $this->assertSame([], json_decode($responseInterface->getBody()->getContents(), true)['data']);
    }

    private function getRequest(): OcpiEmspTokenGetRequest
    {
        return new OcpiEmspTokenGetRequest(
            Psr17FactoryDiscovery::findServerRequestFactory()->createServerRequest('GET', '/test?offset=10&limit=10')
                ->withQueryParams(['offset' => '10', 'limit' => '10'])
                ->withHeader('Authorization', 'Token 01234567-0123-0123-0123-0123456789ab')
        );
    }

    public function validPayloadsProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/valid/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [
                    'payload' => file_get_contents(__DIR__ . '/payloads/valid/' . $filename),
                ];
            }
        }
    }

    /**
     * @dataProvider validPayloadsProvider
     * @param string $payload
     */
    public function testShouldReturnDataWithTokens(string $payload): void
    {
        $response = new OcpiEmspTokenGetResponse(self::getRequest(), 0, 10);
        $tokens = [];
        foreach (json_decode($payload)->data as $index => $jsonToken) {
            $token = TokenFactory::fromJson($jsonToken);
            $tokens[$index] = $token;
            $response->addToken($token);
        }
        $responseInterface = $response->getResponseInterface();
        foreach (json_decode($responseInterface->getBody()->getContents())->data as $index => $jsonToken) {
            TokenTest::assertJsonSerialization($tokens[$index], $jsonToken);
            $schemaPath = __DIR__ . '/../../../../../../../src/Versions/V2_1_1/Client/Schemas/token.schema.json';
            OcpiTestCase::coerce($schemaPath, $jsonToken);
        }
    }
}
