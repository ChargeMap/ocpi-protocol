<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Delete;

use Chargemap\OCPI\Common\Server\OcpiSuccessResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;

class OcpiEmspCredentialsDeleteResponse extends OcpiSuccessResponse
{
    public function __construct(string $statusMessage = null)
    {
        parent::__construct(OcpiSuccessHttpCode::HTTP_OK(), $statusMessage);
    }

    protected function getData()
    {
        return null;
    }
}
