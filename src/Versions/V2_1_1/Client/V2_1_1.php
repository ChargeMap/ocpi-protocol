<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class V2_1_1 extends AbstractFeatures
{
    private Locations $locations;

    public function locations(): Locations
    {
        if (!isset($this->locations)) {
            $this->locations = new Locations($this->ocpiConfiguration);
        }

        return $this->locations;
    }
}
