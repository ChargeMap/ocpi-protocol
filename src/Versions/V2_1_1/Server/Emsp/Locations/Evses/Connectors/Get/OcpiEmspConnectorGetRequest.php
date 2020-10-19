<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Get\OcpiEmspEvseGetRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

class OcpiEmspConnectorGetRequest extends OcpiEmspEvseGetRequest
{
    protected string $connectorId;

    public function __construct(ServerRequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request, $params);
        $connectorId = $params->getConnectorId();
        if ($connectorId === null) {
            throw new InvalidArgumentException('Connector Id should be provided.');
        }
        $this->connectorId = $connectorId;
    }

    public function getConnectorId(): string
    {
        return $this->connectorId;
    }
}
