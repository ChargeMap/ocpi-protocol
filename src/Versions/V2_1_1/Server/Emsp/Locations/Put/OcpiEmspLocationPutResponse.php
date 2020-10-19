<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Put;

use Chargemap\OCPI\Common\Server\OcpiCreateResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location;

class OcpiEmspLocationPutResponse extends OcpiCreateResponse
{
    private Location $location;

    public function __construct(Location $location)
    {
        parent::__construct('Location successfully created.');
        $this->location = $location;
    }

    protected function getData()
    {
        return null;
    }
}
