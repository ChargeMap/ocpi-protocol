<?php

namespace Tests\Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\Errors\OcpiClientError;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiClientErrorStatusCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorHttpCode;
use DateTime;
use PHPUnit\Framework\TestCase;

class OcpiClientErrorTest extends TestCase
{
    public function testShouldTransformToResponse(): void
    {
        $clientError = new OcpiClientError(OcpiClientErrorStatusCode::ERROR_CLIENT(), "Message!");
        $errorResponse = $clientError->getResponseInterface();
        $errorResponseBody = json_decode($errorResponse->getBody()->getContents(), false);

        $this->assertSame( OcpiClientErrorStatusCode::ERROR_CLIENT, $errorResponseBody->status_code);
        $this->assertSame( 'Message!', $errorResponseBody->status_message );

        // As timestamp is generated live, with need to check that it was generated about at the same time,
        // but not exact time as the test may take a little while to run
        $this->assertTrue( (new DateTime($errorResponseBody->timestamp))->getTimestamp() - (new DateTime())->getTimestamp() < 1 );

        $this->assertSame(OcpiErrorHttpCode::HTTP_BAD_REQUEST, $errorResponse->getStatusCode());
    }
}
