<?php

namespace Chargemap\OCPI\Common\Client;

use Chargemap\OCPI\Common\Client\Modules\Locations;
use Chargemap\OCPI\Common\Client\Modules\Versions;
use Chargemap\OCPI\Common\Client\Modules\Versions\GetDetails\GetVersionDetailRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\V2_1_1;

class OcpiClient
{
    private OcpiConfiguration $configuration;

    private Versions $versions;

    private Locations $locations;

    public function __construct(OcpiConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function V2_1_1(): V2_1_1
    {
        return new V2_1_1($this->configuration);
    }

    public function autoConfigureEndpoints(): void
    {
        foreach ($this->versions->getAvailableVersions()->getVersions() as $version) {
            foreach ($this->versions->getVersionDetail(new GetVersionDetailRequest($version))->getOcpiEndpoints() as $endpoint) {
                $this->configuration->withEndpoint($endpoint);
            }
        }
    }

    public function versions(): Versions
    {
        if ($this->versions === null) {
            $this->versions = new Versions($this->configuration);
        }

        return $this->versions;
    }

    public function locations(): Locations
    {
        if ($this->locations === null) {
            $this->locations = new Locations($this->configuration);
        }

        return $this->locations;
    }
}
