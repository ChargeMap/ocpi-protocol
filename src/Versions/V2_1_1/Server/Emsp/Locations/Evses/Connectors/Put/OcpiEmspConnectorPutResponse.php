<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Put;

use Chargemap\OCPI\Common\Server\OcpiCreateResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Connector;

class OcpiEmspConnectorPutResponse extends OcpiCreateResponse
{
    private Connector $connector;

    public function __construct(Connector $connector, string $statusMessage = 'Connector successfully created.')
    {
        parent::__construct($statusMessage);
        $this->connector = $connector;
    }

    protected function getData()
    {
        return null;
    }
}
