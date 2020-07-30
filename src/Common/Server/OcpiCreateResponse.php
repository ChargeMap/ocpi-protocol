<?php

namespace Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;

abstract class OcpiCreateResponse extends OcpiSuccessResponse
{
    /**
     * @param string|null $statusMessage
     */
    public function __construct(string $statusMessage = null)
    {
        parent::__construct(OcpiSuccessHttpCode::HTTP_CREATED(), $statusMessage);
    }
}
