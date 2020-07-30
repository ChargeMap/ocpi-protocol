<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch;

use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialLocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialLocation;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\OcpiLocationUpdateRequest;
use Psr\Http\Message\RequestInterface;
use UnexpectedValueException;

class OcpiEmspLocationPatchRequest extends OcpiLocationUpdateRequest
{
    private PartialLocation $partialLocation;

    public function __construct(RequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request, $params);
        PayloadValidation::coerce('Versions/V2_1_1/Server/Emsp/Schemas/locationPatch.schema.json', $this->jsonBody);
        $partialLocation = PartialLocationFactory::fromJson($this->jsonBody);
        if ($partialLocation === null) {
            throw new UnexpectedValueException('PartialLocation cannot be null');
        }
        $this->partialLocation = $partialLocation;
    }

    public function getPartialLocation(): PartialLocation
    {
        return $this->partialLocation;
    }
}
