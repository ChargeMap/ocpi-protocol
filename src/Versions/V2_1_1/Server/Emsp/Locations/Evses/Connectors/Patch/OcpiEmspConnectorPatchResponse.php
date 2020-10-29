<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Patch;

use Chargemap\OCPI\Common\Server\OcpiUpdateResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialConnector;

class OcpiEmspConnectorPatchResponse extends OcpiUpdateResponse
{
    private PartialConnector $partialConnector;

    public function __construct(
        PartialConnector $partialConnector,
        string $statusMessage = 'Connector successfully updated'
    ) {
        parent::__construct($statusMessage);
        $this->partialConnector = $partialConnector;
    }

    protected function getData()
    {
        return null;
    }
}
