<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Put;

use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\OcpiLocationUpdateRequest;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class OcpiEmspLocationPutRequest extends OcpiLocationUpdateRequest
{
    private Location $location;

    public function __construct(ServerRequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request, $params);
        PayloadValidation::coerce('Versions/V2_1_1/Server/Emsp/Schemas/locationPut.schema.json', $this->jsonBody);
        $location = LocationFactory::fromJson($this->jsonBody);
        if ($location === null) {
            throw new UnexpectedValueException('Location cannot be null');
        }
        $this->location = $location;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }
}
