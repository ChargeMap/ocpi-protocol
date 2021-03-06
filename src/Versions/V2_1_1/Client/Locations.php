<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingService;

class Locations extends AbstractFeatures
{
    public function getListing(?GetLocationsListingRequest $listingRequest = null): GetLocationsListingResponse
    {
        if ($listingRequest === null) {
            $listingRequest = new GetLocationsListingRequest();
        }

        return (new GetLocationsListingService($this->ocpiConfiguration))->handle($listingRequest);
    }
}
