<?php

namespace Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\OcpiErrorResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiClientErrorStatusCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorHttpCode;
use Throwable;

class OcpiUnknownLocationClientError extends OcpiClientError
{
    public function __construct(string $message = "", Throwable $previous = null)
    {
        parent::__construct(OcpiClientErrorStatusCode::ERROR_CLIENT_UNKNOWN_LOCATION(), $message, $previous);
    }

    public function toOcpiResponse(OcpiErrorHttpCode $code = null): OcpiErrorResponse
    {
        return new OcpiErrorResponse($code ?? OcpiErrorHttpCode::HTTP_NOT_FOUND(), $this->ocpiStatusCode, $this->getMessage());
    }
}
