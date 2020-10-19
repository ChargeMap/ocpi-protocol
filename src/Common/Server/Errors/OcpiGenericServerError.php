<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiServerErrorStatusCode;
use Throwable;

class OcpiGenericServerError extends OcpiServerError
{
    public function __construct(string $message = "", Throwable $previous = null)
    {
        parent::__construct(OcpiServerErrorStatusCode::ERROR_SERVER(), $message, $previous);
    }
}
