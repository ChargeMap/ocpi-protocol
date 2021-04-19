<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingService;

class Locations extends AbstractFeatures
{
    /***
     * @param GetLocationRequest $request
     * @return GetLocationResponse
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Client\OcpiUnauthorizedException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function get(GetLocationRequest $request): GetLocationResponse
    {
        return (new GetLocationService($this->ocpiConfiguration))->handle($request);
    }

    /**
     * @param GetLocationsListingRequest|null $listingRequest
     * @return GetLocationsListingResponse
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Client\OcpiUnauthorizedException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getListing(?GetLocationsListingRequest $listingRequest = null): GetLocationsListingResponse
    {
        if ($listingRequest === null) {
            $listingRequest = new GetLocationsListingRequest();
        }

        return (new GetLocationsListingService($this->ocpiConfiguration))->handle($listingRequest);
    }
}
