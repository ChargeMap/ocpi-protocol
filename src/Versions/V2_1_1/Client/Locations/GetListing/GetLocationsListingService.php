<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use JsonException;

class GetLocationsListingService extends AbstractFeatures
{
    /**
     * @param GetLocationsListingRequest $request
     * @return GetLocationsListingResponse
     * @throws OcpiUnauthorizedException|JsonException
     */
    public function handle(GetLocationsListingRequest $request): GetLocationsListingResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetLocationsListingResponse::from($request, $responseInterface);
    }
}
