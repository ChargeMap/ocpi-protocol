<?php

namespace Tests\Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\OcpiBaseResponse;
use Chargemap\OCPI\Common\Server\OcpiErrorResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiClientErrorStatusCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorHttpCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorStatusCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiServerErrorStatusCode;
use PHPUnit\Framework\TestCase;

class OcpiErrorResponseTest extends TestCase
{
    public function validCodesProvider(): array
    {
        return [
            [OcpiErrorHttpCode::HTTP_BAD_REQUEST(), OcpiClientErrorStatusCode::ERROR_CLIENT()],
            [OcpiErrorHttpCode::HTTP_BAD_REQUEST(), OcpiServerErrorStatusCode::ERROR_SERVER()],
        ];
    }

    /**
     * @dataProvider validCodesProvider
     * @param OcpiErrorHttpCode $ocpiHttpCode
     * @param OcpiErrorStatusCode $ocpiStatusCode
     */
    public function testShouldBeConstructedWithValidCodes(OcpiErrorHttpCode $ocpiHttpCode, OcpiErrorStatusCode $ocpiStatusCode): void
    {
        $errorResponse = new OcpiErrorResponse($ocpiHttpCode, $ocpiStatusCode, null);
        $this->assertInstanceOf(OcpiErrorResponse::class, $errorResponse);
        $this->assertInstanceOf(OcpiBaseResponse::class, $errorResponse);
    }
}
