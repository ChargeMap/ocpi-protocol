<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiClientErrorStatusCode;
use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use PHPUnit\Framework\TestCase;

class OcpiInvalidPayloadClientErrorTest extends TestCase
{
    public function testShouldTransformToResponse(): void
    {
        $clientError = new OcpiInvalidPayloadClientError();
        $errorResponse = $clientError->getResponseInterface();
        $errorResponseBody = json_decode($errorResponse->getBody()->getContents(), true);
        $this->assertEquals([
            'status_code' => OcpiClientErrorStatusCode::ERROR_CLIENT_INVALID_PARAMETERS,
            'status_message' => 'Provided payload is invalid',
            'timestamp' => DateTimeFormatter::format((new DateTime())),
        ], $errorResponseBody);
    }
}
