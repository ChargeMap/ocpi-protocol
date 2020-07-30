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
        $errorResponseBody = json_decode($errorResponse->getBody()->getContents(), true);
        $this->assertEquals([
            'status_code' => OcpiClientErrorStatusCode::ERROR_CLIENT,
            'status_message' => 'Message!',
            'timestamp' => (new DateTime())->format(DateTime::ISO8601),
        ], $errorResponseBody);
        $this->assertEquals(OcpiErrorHttpCode::HTTP_BAD_REQUEST, $errorResponse->getStatusCode());
    }
}
