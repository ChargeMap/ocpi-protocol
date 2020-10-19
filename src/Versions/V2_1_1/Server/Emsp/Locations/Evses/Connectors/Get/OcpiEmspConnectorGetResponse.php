<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Get;

use Chargemap\OCPI\Common\Server\OcpiSuccessResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Connector;

class OcpiEmspConnectorGetResponse extends OcpiSuccessResponse
{
    private Connector $connector;

    public function __construct(Connector $connector, string $statusMessage = null)
    {
        parent::__construct(OcpiSuccessHttpCode::HTTP_OK(), $statusMessage);
        $this->connector = $connector;
    }

    protected function getData(): Connector
    {
        return $this->connector;
    }
}
