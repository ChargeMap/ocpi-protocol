<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations;

use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Psr\Http\Message\RequestInterface;

abstract class OcpiLocationUpdateRequest extends OcpiUpdateRequest
{
    protected string $countryCode;

    protected string $partyId;

    protected string $locationId;

    protected function __construct(RequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request);
        $this->countryCode = $params->getCountryCode();
        $this->partyId = $params->getPartyId();
        $this->locationId = $params->getLocationId();
    }

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
}
