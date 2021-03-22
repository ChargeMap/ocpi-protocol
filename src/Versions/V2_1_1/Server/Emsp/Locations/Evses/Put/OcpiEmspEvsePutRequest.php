<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Put;

use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\EVSEFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EVSE;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\BaseEvseUpdateRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class OcpiEmspEvsePutRequest extends BaseEvseUpdateRequest
{
    private EVSE $evse;

    public function __construct(ServerRequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request, $params);
        PayloadValidation::coerce('Locations/Evses/evsePutRequest.schema.json', $this->jsonBody);
        $evse = EVSEFactory::fromJson($this->jsonBody);
        if ($evse === null) {
            throw new UnexpectedValueException('Evse cannot be null');
        }
        $this->evse = $evse;
    }

    public function getEvse(): EVSE
    {
        return $this->evse;
    }
}
