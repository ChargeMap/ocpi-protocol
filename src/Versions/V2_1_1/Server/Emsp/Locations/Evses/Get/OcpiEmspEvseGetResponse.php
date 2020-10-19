<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Get;

use Chargemap\OCPI\Common\Server\OcpiSuccessResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EVSE;

class OcpiEmspEvseGetResponse extends OcpiSuccessResponse
{
    private EVSE $evse;

    public function __construct(EVSE $evse, string $statusMessage = null)
    {
        parent::__construct(OcpiSuccessHttpCode::HTTP_OK(), $statusMessage);
        $this->evse = $evse;
    }

    protected function getData(): EVSE
    {
        return $this->evse;
    }
}
