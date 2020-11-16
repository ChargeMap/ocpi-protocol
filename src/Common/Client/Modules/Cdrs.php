<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Client\Modules\Cdrs\GetListing\GetCdrsListingRequest;
use Chargemap\OCPI\Common\Client\Modules\Cdrs\GetListing\GetCdrsListingResponse;
use Chargemap\OCPI\Common\Client\Modules\Cdrs\GetListing\GetCdrsListingService;

class Cdrs extends AbstractFeatures
{
    private GetCdrsListingService $cdrListingService;

    public function getListing(GetCdrsListingRequest $request): GetCdrsListingResponse
    {
        if ($this->cdrListingService === null) {
            $this->cdrListingService = new GetCdrsListingService($this->ocpiConfiguration);
        }
        return $this->cdrListingService->handle($request);
    }
}