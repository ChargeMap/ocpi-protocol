<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations;

trait LocationRequestTrait
{
    protected string $countryCode;

    protected string $partyId;

    protected string $locationId;

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getPartyId(): string
    {
        return $this->partyId;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    protected function dispatchParams(LocationRequestParams $params)
    {
        $this->countryCode = $params->getCountryCode();
        $this->partyId = $params->getPartyId();
        $this->locationId = $params->getLocationId();
    }
}
