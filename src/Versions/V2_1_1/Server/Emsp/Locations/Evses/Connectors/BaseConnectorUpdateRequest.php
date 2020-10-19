<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\BaseEvseUpdateRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Psr\Http\Message\ServerRequestInterface;

abstract class BaseConnectorUpdateRequest extends BaseEvseUpdateRequest
{
    protected string $connectorId;

    protected function __construct(ServerRequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request, $params);
        $connectorId = $params->getConnectorId();

        if ($connectorId === null) {
            throw new OcpiNotEnoughInformationClientError('Connector Id should be provided.');
        }

        $this->connectorId = $connectorId;
    }

    public function getConnectorId(): string
    {
        return $this->connectorId;
    }
}
