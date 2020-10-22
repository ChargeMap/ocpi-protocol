<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Tokens\Put;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Common\Client\OcpiServiceNotFoundException;
use Chargemap\OCPI\Common\Client\ServiceFactory;

class PutTokenService extends AbstractFeatures
{
    public function handle(PutTokenRequest $request): PutTokenResponse
    {
        $service = ServiceFactory::from($request, $this->ocpiConfiguration);

        switch (get_class($service)) {
            case \Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Put\PutTokenService::class:
                return $service->handle($request);
        }

        throw new OcpiServiceNotFoundException($request->getVersion(), get_class($request), sprintf('No service found for query %s', get_class($service)));
    }
}