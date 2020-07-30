<?php

namespace Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiServerErrorStatusCode;
use Throwable;

class OcpiUnsupportedVersionServerError extends OcpiServerError
{
    public function __construct(string $message = "", Throwable $previous = null)
    {
        parent::__construct(OcpiServerErrorStatusCode::ERROR_SERVER_UNSUPPORTED_VERSION(), $message, $previous);
    }
}
