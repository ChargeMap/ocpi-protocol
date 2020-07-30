<?php

namespace Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\OcpiErrorResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiClientErrorStatusCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorHttpCode;
use Throwable;

class OcpiIsNotRegisteredClientError extends OcpiClientError
{
    public function __construct(string $message = "A client with these credentials is not registered.", Throwable $previous = null)
    {
        parent::__construct(OcpiClientErrorStatusCode::ERROR_CLIENT_INVALID_PARAMETERS(), $message, $previous);
    }

    public function toOcpiResponse(OcpiErrorHttpCode $code = null): OcpiErrorResponse
    {
        return new OcpiErrorResponse($code ?? OcpiErrorHttpCode::HTTP_METHOD_NOT_ALLOWED(), $this->ocpiStatusCode, $this->getMessage());
    }
}
