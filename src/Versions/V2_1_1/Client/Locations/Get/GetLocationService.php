<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use JsonException;

class GetLocationService extends AbstractFeatures
{
    /**
     * @param GetLocationRequest $request
     * @return GetLocationResponse
     * @throws OcpiUnauthorizedException|JsonException
     */
    public function handle(GetLocationRequest $request): GetLocationResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetLocationResponse::from($responseInterface);
    }
}
