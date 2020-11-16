<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing\GetCdrsListingRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing\GetCdrsListingResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing\GetCdrsListingService;

class Cdrs extends AbstractFeatures
{
    public function getListing(?GetCdrsListingRequest $listingRequest = null): GetCdrsListingResponse
    {
        if ($listingRequest === null) {
            $listingRequest = new GetCdrsListingRequest();
        }

        return (new GetCdrsListingService($this->ocpiConfiguration))->handle($listingRequest);
    }
}
