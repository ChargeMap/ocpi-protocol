<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\OcpiErrorResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiClientErrorStatusCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorHttpCode;
use Throwable;

class OcpiNotEnoughInformationClientError extends OcpiClientError
{
    public function __construct(string $message = 'Not enough information', Throwable $previous = null)
    {
        parent::__construct(OcpiClientErrorStatusCode::ERROR_CLIENT_NOT_ENOUGH_INFO(), $message, $previous);
    }

    public function toOcpiResponse(OcpiErrorHttpCode $code = null): OcpiErrorResponse
    {
        return new OcpiErrorResponse($code ?? OcpiErrorHttpCode::HTTP_NOT_FOUND(), $this->ocpiStatusCode, $this->getMessage());
    }
}
