<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorHttpCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorStatusCode;

class OcpiErrorResponse extends OcpiBaseResponse
{
    public function __construct(OcpiErrorHttpCode $ocpiHttpCode, OcpiErrorStatusCode $ocpiStatusCode, string $statusMessage = null)
    {
        parent::__construct($ocpiHttpCode, $ocpiStatusCode, $statusMessage);
    }
}
