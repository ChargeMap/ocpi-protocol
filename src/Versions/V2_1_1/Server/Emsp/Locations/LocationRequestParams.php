<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations;

use InvalidArgumentException;

class LocationRequestParams
{
    private string $countryCode;

    private string $partyId;

    private string $locationId;

    private ?string $evseUid;

    private ?string $connectorId;

    public function __construct(string $countryCode, string $partyId, string $locationId, string $evseUid = null, string $connectorId = null)
    {
        if (empty($countryCode) || mb_strlen($countryCode) !== 2) {
            throw new InvalidArgumentException('Country code should contain exactly 2 letters.');
        }

        if (empty ($partyId) || mb_strlen($partyId) !== 3) {
            throw new InvalidArgumentException('Party ID should contain exactly 3 characters.');
        }

        if (empty($locationId) || mb_strlen($locationId) > 39) {
            throw new InvalidArgumentException('Location ID should contain less than 39 characters.');
        }

        if ($evseUid !== null && (empty($evseUid) || mb_strlen($evseUid) > 39)) {
            throw new InvalidArgumentException('EVSE UID should contain less than 39 characters.');
        }

        if ($connectorId !== null && (empty($connectorId) || mb_strlen($connectorId) > 36)) {
            throw new InvalidArgumentException('Connector ID should contain less than 36 characters.');
        }

        $this->countryCode = $countryCode;
        $this->partyId = $partyId;
        $this->locationId = $locationId;
        $this->evseUid = $evseUid;
        $this->connectorId = $connectorId;
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

    public function getEvseUid(): ?string
    {
        return $this->evseUid;
    }

    public function getConnectorId(): ?string
    {
        return $this->connectorId;
    }
}
