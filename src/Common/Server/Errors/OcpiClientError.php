<?php

namespace Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\OcpiErrorResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiClientErrorStatusCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorHttpCode;
use Throwable;

class OcpiClientError extends OcpiError
{
    public function __construct(OcpiClientErrorStatusCode $ocpiStatusCode, string $message = "", Throwable $previous = null)
    {
        parent::__construct($ocpiStatusCode, $message, $previous);
    }

    public function toOcpiResponse(OcpiErrorHttpCode $code = null): OcpiErrorResponse
    {
        return new OcpiErrorResponse($code ?? OcpiErrorHttpCode::HTTP_BAD_REQUEST(), $this->ocpiStatusCode, $this->getMessage());
    }
}
