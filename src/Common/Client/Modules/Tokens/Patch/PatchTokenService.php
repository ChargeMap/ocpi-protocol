<?php


namespace Chargemap\OCPI\Common\Client\Modules\Tokens\Patch;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Common\Client\OcpiServiceNotFoundException;
use Chargemap\OCPI\Common\Client\ServiceFactory;

class PatchTokenService extends AbstractFeatures
{
    public function handle(PatchTokenRequest $request): PatchTokenResponse
    {
        $service = ServiceFactory::from($request, $this->ocpiConfiguration);

        switch (get_class($service)) {
            case PatchTokenService::class:
                return $service->handle($request);
        }

        throw new OcpiServiceNotFoundException($request->getVersion(), get_class($request), sprintf('No service found for query %s', get_class($service)));
    }
}