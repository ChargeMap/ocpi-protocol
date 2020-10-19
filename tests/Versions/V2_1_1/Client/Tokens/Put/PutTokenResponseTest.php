<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Put;

use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Put\PutTokenResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class PutTokenResponseTest extends TestCase
{
    public function testGetResponseInterface(): void
    {
        $responseInterface = $this->getMockForAbstractClass(ResponseInterface::class);
        $response = new PutTokenResponse($responseInterface);
        $this->assertSame($responseInterface, $response->getResponseInterface());
    }
}
