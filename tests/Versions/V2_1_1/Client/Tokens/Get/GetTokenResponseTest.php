<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Token;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class GetTokenResponseTest extends TestCase
{
    public function testWithDocumentationExamplePayload(): void
    {
        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream(file_get_contents(__DIR__ . '/payloads/get_token_response.json'))
            );

        /** @var Token $token */
        $token = GetTokenResponse::from($serverResponse)->getToken();

        $this->assertSame('012345678', $token->getUid());
        $this->assertSame('RFID', $token->getType()->getValue());
        $this->assertSame('DE8ACC12E46L89', $token->getAuthId());
        $this->assertSame('DF000-2001-8999', $token->getVisualNumber());
        $this->assertSame('TheNewMotion', $token->getIssuer());
        $this->assertTrue($token->isValid());
        $this->assertSame('ALWAYS', $token->getWhiteList()->getValue());
        $this->assertNull($token->getWhiteList());
        $this->assertEquals(new DateTime('2015-06-29T22:39:09Z'), $token->getLastUpdated());
    }
}
