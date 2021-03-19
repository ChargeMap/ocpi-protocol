<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Locations\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Common\Client\OcpiServiceNotFoundException;
use Chargemap\OCPI\Common\Client\ServiceFactory;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationResponse as V2_1_1GetLocationResponse;
use JsonException;

class GetLocationService extends AbstractFeatures
{
    /**
     * @param GetLocationRequest $request
     * @return GetLocationResponse|V2_1_1GetLocationResponse
     * @throws OcpiServiceNotFoundException|JsonException
     */
    public function handle(GetLocationRequest $request): GetLocationResponse
    {
        $service = ServiceFactory::from($request, $this->ocpiConfiguration);

        switch (get_class($service)) {
            case \Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationService::class:
                return $service->handle($request);
        }

        throw new OcpiServiceNotFoundException($request->getVersion(), get_class($request), sprintf('No service found for query %s', get_class($service)));
    }
}
