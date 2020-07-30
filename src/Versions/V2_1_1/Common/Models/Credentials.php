<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class Credentials implements JsonSerializable
{
    private string $token;

    private string $url;

    private BusinessDetails $businessDetails;

    private string $partyId;

    private string $countryCode;

    public function __construct(string $token, string $url, BusinessDetails $businessDetails, string $partyId, string $countryCode)
    {
        $this->token = $token;
        $this->url = $url;
        $this->businessDetails = $businessDetails;
        $this->partyId = $partyId;
        $this->countryCode = $countryCode;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getBusinessDetails(): BusinessDetails
    {
        return $this->businessDetails;
    }

    public function getPartyId(): string
    {
        return $this->partyId;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token,
            'url' => $this->url,
            'business_details' => $this->businessDetails,
            'party_id' => $this->partyId,
            'country_code' => $this->countryCode,
        ];
    }
}
