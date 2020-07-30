<?php

namespace Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\OcpiErrorResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorHttpCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiServerErrorStatusCode;
use Throwable;

class OcpiNoMatchingEndpointsServerError extends OcpiServerError
{
    public function __construct(string $message = "", Throwable $previous = null)
    {
        parent::__construct(OcpiServerErrorStatusCode::ERROR_SERVER_NO_MATCHING_ENDPOINTS(), $message, $previous);
    }

    public function toOcpiResponse(OcpiErrorHttpCode $code = null): OcpiErrorResponse
    {
        return new OcpiErrorResponse($code ?? OcpiErrorHttpCode::HTTP_NOT_FOUND(), $this->ocpiStatusCode, $this->getMessage());
    }
}
