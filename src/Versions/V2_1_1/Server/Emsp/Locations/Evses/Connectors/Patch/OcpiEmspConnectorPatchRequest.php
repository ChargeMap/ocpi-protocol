<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Patch;

use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialConnectorFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialConnector;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\BaseConnectorUpdateRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch\UnsupportedPatchException;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class OcpiEmspConnectorPatchRequest extends BaseConnectorUpdateRequest
{
    private PartialConnector $partialConnector;

    public function __construct(ServerRequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request, $params);
        PayloadValidation::coerce('Locations/Evses/Connectors/connectorPatchRequest.schema.json', $this->jsonBody);
        $partialConnector = PartialConnectorFactory::fromJson($this->jsonBody);
        if ($partialConnector === null) {
            throw new UnexpectedValueException('PartialConnector cannot be null');
        }

        if($partialConnector->hasId() && $partialConnector->getId() !== $params->getConnectorId()) {
            throw new UnsupportedPatchException( 'Property id can not be patched at the moment' );
        }

        $this->partialConnector = $partialConnector;
    }

    public function getPartialConnector(): PartialConnector
    {
        return $this->partialConnector;
    }
}
