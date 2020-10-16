<?php


namespace Chargemap\OCPI\Common\Client\Modules\Tokens\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Common\Client\OcpiServiceNotFoundException;
use Chargemap\OCPI\Common\Client\ServiceFactory;

class GetTokenService extends AbstractFeatures
{
    public function handle(GetTokenRequest $request): GetTokenResponse
    {
        $service = ServiceFactory::from($request, $this->ocpiConfiguration);

        switch (get_class($service)) {
            case \Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get\GetTokenService::class:
                return $service->handle($request);
        }

        throw new OcpiServiceNotFoundException($request->getVersion(), get_class($request), sprintf('No service found for query %s', get_class($service)));
    }
}
