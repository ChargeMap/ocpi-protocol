<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class V2_1_1 extends AbstractFeatures
{
    private Credentials $credentials;

    private Locations $locations;

    private Tokens $tokens;

    private Cdrs $cdrs;

    public function credentials(): Credentials
    {
        if (!isset($this->credentials)) {
            $this->credentials = new Credentials($this->ocpiConfiguration);
        }

        return $this->credentials;
    }

    public function locations(): Locations
    {
        if (!isset($this->locations)) {
            $this->locations = new Locations($this->ocpiConfiguration);
        }

        return $this->locations;
    }

    public function tokens(): Tokens
    {
        if (!isset($this->tokens)) {
            $this->tokens = new Tokens($this->ocpiConfiguration);
        }

        return $this->tokens;
    }

    public function cdrs(): Cdrs
    {
        if (!isset($this->cdrs)) {
            $this->cdrs = new Cdrs($this->ocpiConfiguration);
        }

        return $this->cdrs;
    }
}
