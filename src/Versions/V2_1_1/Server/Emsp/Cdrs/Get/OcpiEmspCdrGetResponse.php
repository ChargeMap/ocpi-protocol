<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get;

use Chargemap\OCPI\Common\Server\OcpiSuccessResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Cdr;

class OcpiEmspCdrGetResponse extends OcpiSuccessResponse
{
    private Cdr $cdr;

    public function __construct(Cdr $cdr)
    {
        parent::__construct(OcpiSuccessHttpCode::HTTP_OK(), null);
        $this->cdr = $cdr;
    }

    protected function getData(): Cdr
    {
        return $this->cdr;
    }
}
