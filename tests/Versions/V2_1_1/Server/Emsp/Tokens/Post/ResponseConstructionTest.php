<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Post;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AllowedType;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Post\OcpiEmspTokenPostResponse;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    public function testDataIsCorrect(): void
    {

        $response = new OcpiEmspTokenPostResponse(AllowedType::ALLOWED(), null, null);
        $responseInterface = $response->getResponseInterface();

        $this->assertEquals([
            'allowed' => 'ALLOWED',
            'location' => null,
            'info' => null
        ], json_decode($responseInterface->getBody()->getContents(), true)['data']);
    }
}
