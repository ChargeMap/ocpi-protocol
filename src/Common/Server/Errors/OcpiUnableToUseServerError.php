<?php

namespace Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiServerErrorStatusCode;
use Throwable;

class OcpiUnableToUseServerError extends OcpiServerError
{
    public function __construct(string $message = "", Throwable $previous = null)
    {
        parent::__construct(OcpiServerErrorStatusCode::ERROR_SERVER_UNABLE_TO_USE(), $message, $previous);
    }
}
