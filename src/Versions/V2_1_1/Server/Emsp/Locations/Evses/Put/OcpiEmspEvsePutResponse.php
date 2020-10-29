<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Put;

use Chargemap\OCPI\Common\Server\OcpiCreateResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EVSE;

class OcpiEmspEvsePutResponse extends OcpiCreateResponse
{
    private EVSE $evse;

    public function __construct(EVSE $evse, string $statusMessage = 'EVSE successfully created.')
    {
        parent::__construct($statusMessage);
        $this->evse = $evse;
    }

    protected function getData()
    {
        return null;
    }
}
