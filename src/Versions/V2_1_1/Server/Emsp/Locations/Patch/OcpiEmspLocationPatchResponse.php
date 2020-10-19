<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch;

use Chargemap\OCPI\Common\Server\OcpiUpdateResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialLocation;

class OcpiEmspLocationPatchResponse extends OcpiUpdateResponse
{
    private PartialLocation $partialLocation;

    public function __construct(PartialLocation $partialLocation)
    {
        parent::__construct('Location successfully updated.');
        $this->partialLocation = $partialLocation;
    }

    protected function getData()
    {
        return null;
    }
}
