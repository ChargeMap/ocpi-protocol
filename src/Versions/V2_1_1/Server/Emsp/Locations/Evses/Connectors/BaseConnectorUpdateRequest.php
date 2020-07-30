<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\BaseEvseUpdateRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;

abstract class BaseConnectorUpdateRequest extends BaseEvseUpdateRequest
{
    protected string $connectorId;

    protected function __construct(RequestInterface $request, LocationRequestParams $params)
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
