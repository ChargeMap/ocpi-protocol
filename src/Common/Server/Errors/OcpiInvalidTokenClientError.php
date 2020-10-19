<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiClientErrorStatusCode;
use Throwable;

class OcpiInvalidTokenClientError extends OcpiClientError
{
    public function __construct(string $message = 'Provided token is invalid', Throwable $previous = null)
    {
        parent::__construct(OcpiClientErrorStatusCode::ERROR_CLIENT_INVALID_PARAMETERS(), $message, $previous);
    }
}
