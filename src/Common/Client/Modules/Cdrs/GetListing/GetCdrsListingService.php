<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Cdrs\GetListing;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Common\Client\OcpiServiceNotFoundException;
use Chargemap\OCPI\Common\Client\ServiceFactory;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing\GetCdrsListingResponse as V2_1_1GetCdrsListingResponse;

class GetCdrsListingService extends AbstractFeatures
{
    /**
     * @param GetCdrsListingRequest $request
     * @return GetCdrsListingResponse|V2_1_1GetCdrsListingResponse
     * @throws OcpiServiceNotFoundException
     */
    public function handle(GetCdrsListingRequest $request): GetCdrsListingResponse
    {
        $service = ServiceFactory::from($request, $this->ocpiConfiguration);

        switch (get_class($service)) {
            case GetCdrsListingService::class:
                return $service->handle($request);
        }

        throw new OcpiServiceNotFoundException($request->getVersion(), get_class($request), sprintf('No service found for query %s', get_class($service)));
    }
}
