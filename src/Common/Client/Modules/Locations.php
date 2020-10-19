<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Client\Modules\Locations\GetListing\GetLocationsListingRequest;
use Chargemap\OCPI\Common\Client\Modules\Locations\GetListing\GetLocationsListingResponse;
use Chargemap\OCPI\Common\Client\Modules\Locations\GetListing\GetLocationsListingService;

class Locations extends AbstractFeatures
{
    private GetLocationsListingService $locationListingService;

    public function getListing(GetLocationsListingRequest $request): GetLocationsListingResponse
    {
        if ($this->locationListingService === null) {
            $this->locationListingService = new GetLocationsListingService($this->ocpiConfiguration);
        }

        return $this->locationListingService->handle($request);
    }
}
