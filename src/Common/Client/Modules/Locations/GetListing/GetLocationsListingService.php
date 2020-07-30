<?php

namespace Chargemap\OCPI\Common\Client\Modules\Locations\GetListing;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Common\Client\OcpiServiceNotFoundException;
use Chargemap\OCPI\Common\Client\ServiceFactory;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingResponse as V2_1_1GetLocationsListingResponse;

class GetLocationsListingService extends AbstractFeatures
{
    /**
     * @param GetLocationsListingRequest $request
     * @return GetLocationsListingResponse|V2_1_1GetLocationsListingResponse
     * @throws OcpiServiceNotFoundException
     */
    public function handle(GetLocationsListingRequest $request): GetLocationsListingResponse
    {
        $service = ServiceFactory::from($request, $this->ocpiConfiguration);

        switch (get_class($service)) {
            case \Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingService::class:
                return $service->handle($request);
        }

        throw new OcpiServiceNotFoundException($request->getVersion(), get_class($request), sprintf('No service found for query %s', get_class($service)));
    }
}
