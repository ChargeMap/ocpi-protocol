<?php

namespace Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiClientErrorStatusCode;
use Throwable;

class OcpiGenericClientError extends OcpiClientError
{
    public function __construct(string $message = "", Throwable $previous = null)
    {
        parent::__construct(OcpiClientErrorStatusCode::ERROR_CLIENT(), $message, $previous);
    }
}