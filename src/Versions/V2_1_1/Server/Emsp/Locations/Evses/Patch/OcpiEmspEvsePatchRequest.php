<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Patch;

use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialEVSEFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialEVSE;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\BaseEvseUpdateRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch\UnsupportedPatchException;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class OcpiEmspEvsePatchRequest extends BaseEvseUpdateRequest
{
    private PartialEVSE $partialEvse;

    /**
     * OcpiEmspEvsePatchRequest constructor.
     * @param ServerRequestInterface $request
     * @param LocationRequestParams $params
     * @throws UnsupportedPatchException
     */
    public function __construct(ServerRequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request, $params);
        PayloadValidation::coerce('Locations/Evses/evsePatchRequest.schema.json', $this->jsonBody);
        $partialEvse = PartialEVSEFactory::fromJson($this->jsonBody);

        if ($partialEvse === null) {
            throw new UnexpectedValueException('PartialConnector cannot be null');
        }

        if($partialEvse->hasUid() && $partialEvse->getUid() !== $params->getEvseUid()) {
            throw new UnsupportedPatchException( 'Property uid can not be patched at the moment' );
        }

        $this->partialEvse = $partialEvse;
    }

    public function getPartialEvse(): PartialEVSE
    {
        return $this->partialEvse;
    }
}
