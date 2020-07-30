<?php

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetAvailableVersionsService extends AbstractFeatures
{
    public function get(GetAvailableVersionsRequest $request): GetAvailableVersionsResponse
    {
        $requestInterface = $request->getRequestInterface($this->ocpiConfiguration->getRequestFactory());
        $responseInterface = $this->ocpiConfiguration->getHttpClient()->sendRequest($requestInterface);
        return GetAvailableVersionsResponse::fromResponseInterface($responseInterface);
    }
}
