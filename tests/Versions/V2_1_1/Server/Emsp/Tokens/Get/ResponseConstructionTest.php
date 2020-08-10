<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get\OcpiEmspTokenGetRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get\OcpiEmspTokenGetResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Token;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\TokenType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\WhiteList;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    private function getRequest(): OcpiEmspTokenGetRequest
    {
        return new OcpiEmspTokenGetRequest(
            Psr17FactoryDiscovery::findServerRequestFactory()->createServerRequest('GET', '/test?offset=10&limit=10')
                ->withQueryParams([ 'offset' => '10', 'limit' => '10'])
                ->withHeader('Authorization', 'Token PLOPPLOP')
        );
    }

    public function testShouldReturnEmptyArrayWithoutTokens(): void
    {
        $response = new OcpiEmspTokenGetResponse(self::getRequest(), 0, 10);
        $responseInterface = $response->getResponseInterface();
        $this->assertEquals([], json_decode($responseInterface->getBody()->getContents(), true)['data']);
    }

    public function testShouldReturnDataWithToken(): void
    {
        $response = new OcpiEmspTokenGetResponse(self::getRequest(), 0, 10);
        $response->addToken(new Token(
            '123',
            TokenType::RFID(),
            'D2G23404',
            '777',
            'issuer',
            true,
            WhiteList::ALLOWED(),
            'EN',
            new DateTime()
        ));
        $responseInterface = $response->getResponseInterface();
        $this->assertEquals([
            [
                'uid' => '123',
                'type' => TokenType::RFID(),
                'auth_id' => 'D2G23404',
                'visual_number' => '777',
                'issuer' => 'issuer',
                'valid' => true,
                'whitelist' => WhiteList::ALLOWED(),
                'language' => 'EN',
                'last_updated' => (new DateTime())->format(DateTime::ISO8601)
            ]
        ], json_decode($responseInterface->getBody()->getContents(), true)['data']);
    }

    public function testShouldReturnDataWithTwoTokens(): void
    {
        $response = new OcpiEmspTokenGetResponse(self::getRequest(), 0, 10);
        $response->addToken(new Token(
            '123',
            TokenType::RFID(),
            'D2G23404',
            '777',
            'issuer',
            true,
            WhiteList::ALLOWED(),
            'EN',
            new DateTime()
        ));
        $response->addToken(new Token(
            '321',
            TokenType::RFID(),
            'D2G23404',
            '777',
            'issuer',
            true,
            WhiteList::ALLOWED(),
            'EN',
            new DateTime()
        ));
        $responseInterface = $response->getResponseInterface();
        $this->assertCount(2, json_decode($responseInterface->getBody()->getContents(), true)['data']);
    }
}
