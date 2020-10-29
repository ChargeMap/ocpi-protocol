<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Patch;

use Chargemap\OCPI\Common\Server\OcpiUpdateResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialEVSE;

class OcpiEmspEvsePatchResponse extends OcpiUpdateResponse
{
    private PartialEVSE $partialEvse;

    public function __construct(PartialEVSE $partialEvse, string $statusMessage = 'EVSE successfully updated.')
    {
        parent::__construct($statusMessage);
        $this->partialEvse = $partialEvse;
    }

    protected function getData()
    {
        return null;
    }
}
