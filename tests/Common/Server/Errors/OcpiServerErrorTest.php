<?php

namespace Tests\Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\Errors\OcpiServerError;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorHttpCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiServerErrorStatusCode;
use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use PHPUnit\Framework\TestCase;

class OcpiServerErrorTest extends TestCase
{
    public function testShouldTransformToResponse(): void
    {
        $clientError = new OcpiServerError(OcpiServerErrorStatusCode::ERROR_SERVER(), "Message!");
        $errorResponse = $clientError->getResponseInterface();
        $errorResponseBody = json_decode($errorResponse->getBody()->getContents(), true);
        $this->assertEquals([
            'status_code' => OcpiServerErrorStatusCode::ERROR_SERVER,
            'status_message' => 'Message!',
            'timestamp' => DateTimeFormatter::format((new DateTime())),
        ], $errorResponseBody);
        $this->assertEquals(OcpiErrorHttpCode::HTTP_BAD_REQUEST, $errorResponse->getStatusCode());
    }
}
