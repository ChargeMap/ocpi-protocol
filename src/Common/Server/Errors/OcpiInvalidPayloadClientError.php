<?php

namespace Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiClientErrorStatusCode;
use Throwable;

class OcpiInvalidPayloadClientError extends OcpiClientError
{
    public function __construct(string $message = 'Provided payload is invalid', Throwable $previous = null)
    {
        parent::__construct(OcpiClientErrorStatusCode::ERROR_CLIENT_INVALID_PARAMETERS(), $message, $previous);
    }
}
