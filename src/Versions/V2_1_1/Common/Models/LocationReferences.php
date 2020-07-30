<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class LocationReferences implements JsonSerializable
{
    private string $locationId;

    /** @var string[] */
    private array $evseUids = [];

    /** @var string[] */
    private array $connectorIds = [];

    public function __construct(string $locationId)
    {
        $this->locationId = $locationId;
    }

    public function addEvseUid(string $evseUid): void
    {
        $this->evseUids[] = $evseUid;
    }

    public function addConnectorId($connectorId): void
    {
        $this->connectorIds[] = $connectorId;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    public function getEvseUids(): array
    {
        return $this->evseUids;
    }

    public function getConnectorIds(): array
    {
        return $this->connectorIds;
    }

    public function jsonSerialize(): array
    {
        return [
            'location_id' => $this->locationId,
            'evse_uids' => $this->evseUids,
            'connector_ids' => $this->connectorIds
        ];
    }
}
