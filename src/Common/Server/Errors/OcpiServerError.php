<?php

namespace Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\OcpiErrorResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorHttpCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiServerErrorStatusCode;
use Throwable;

class OcpiServerError extends OcpiError
{
    public function __construct(OcpiServerErrorStatusCode $ocpiStatusCode, string $message = "", Throwable $previous = null)
    {
        parent::__construct($ocpiStatusCode, $message, $previous);
    }

    public function toOcpiResponse(OcpiErrorHttpCode $code = null): OcpiErrorResponse
    {
        return new OcpiErrorResponse($code ?? OcpiErrorHttpCode::HTTP_BAD_REQUEST(), $this->ocpiStatusCode, $this->getMessage());
    }
}
