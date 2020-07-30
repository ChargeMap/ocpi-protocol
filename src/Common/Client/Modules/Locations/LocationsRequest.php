<?php

namespace Chargemap\OCPI\Common\Client\Modules\Locations;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Common\Client\OcpiModule;

abstract class LocationsRequest extends AbstractRequest
{
    public function getModule(): OcpiModule
    {
        return OcpiModule::LOCATIONS();
    }
}
