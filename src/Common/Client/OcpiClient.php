<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client;

use Chargemap\OCPI\Common\Client\Modules\Cdrs;
use Chargemap\OCPI\Common\Client\Modules\Locations;
use Chargemap\OCPI\Common\Client\Modules\Tokens;
use Chargemap\OCPI\Common\Client\Modules\Versions;
use Chargemap\OCPI\Versions\V2_1_1\Client\V2_1_1;

class OcpiClient
{
    private OcpiConfiguration $configuration;

    private ?Versions $versions = null;

    private ?Locations $locations = null;

    private ?Tokens $tokens = null;

    private ?Cdrs $cdrs = null;

    public function __construct(OcpiConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function V2_1_1(): V2_1_1
    {
        return new V2_1_1($this->configuration);
    }

    public function versions(): Versions
    {
        if ($this->versions === null) {
            $this->versions = new Versions($this->configuration);
        }

        return $this->versions;
    }

    /** @deprecated Use V2_1_1()->locations() */
    public function locations(): Locations
    {
        if ($this->locations === null) {
            $this->locations = new Locations($this->configuration);
        }

        return $this->locations;
    }

    /** @deprecated Use V2_1_1()->tokens() */
    public function tokens(): Tokens
    {
        if ($this->tokens === null) {
            $this->tokens = new Tokens($this->configuration);
        }

        return $this->tokens;
    }

    /** @deprecated Use V2_1_1()->cdrs() */
    public function cdrs(): Cdrs
    {
        if ($this->cdrs === null) {
            $this->cdrs = new Cdrs($this->configuration);
        }

        return $this->cdrs;
    }
}
