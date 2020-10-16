<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch\PatchTokenResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class PatchTokenResponseTest extends TestCase
{
    public function testGetResponseInterface(): void
    {
        $responseInterface = $this->getMockForAbstractClass(ResponseInterface::class);
        $response = new PatchTokenResponse($responseInterface);
        $this->assertSame($responseInterface, $response->getResponseInterface());
    }
}
