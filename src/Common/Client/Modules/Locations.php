<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Client\Modules\Locations\Get\GetLocationRequest;
use Chargemap\OCPI\Common\Client\Modules\Locations\Get\GetLocationResponse;
use Chargemap\OCPI\Common\Client\Modules\Locations\Get\GetLocationService;
use Chargemap\OCPI\Common\Client\Modules\Locations\GetListing\GetLocationsListingRequest;
use Chargemap\OCPI\Common\Client\Modules\Locations\GetListing\GetLocationsListingResponse;
use Chargemap\OCPI\Common\Client\Modules\Locations\GetListing\GetLocationsListingService;
use Chargemap\OCPI\Common\Client\OcpiServiceNotFoundException;
use JsonException;

class Locations extends AbstractFeatures
{
    private ?GetLocationsListingService $locationListingService = null;

    /**
     * @param GetLocationsListingRequest $request
     * @return GetLocationsListingResponse
     * @throws OcpiServiceNotFoundException|JsonException
     */
    public function getListing(GetLocationsListingRequest $request): GetLocationsListingResponse
    {
        if ($this->locationListingService === null) {
            $this->locationListingService = new GetLocationsListingService($this->ocpiConfiguration);
        }

        return $this->locationListingService->handle($request);
    }

    private ?GetLocationService $locationService = null;

    /**
     * @param GetLocationRequest $request
     * @return GetLocationResponse
     * @throws OcpiServiceNotFoundException|JsonException
     */
    public function get(GetLocationRequest $request): GetLocationResponse
    {
        if ($this->locationService === null) {
            $this->locationService = new GetLocationService($this->ocpiConfiguration);
        }

        return $this->locationService->handle($request);
    }
}
