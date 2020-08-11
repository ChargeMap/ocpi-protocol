<?php

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetDetails;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetVersionDetailService extends AbstractFeatures
{
    public function get(GetVersionDetailRequest $request): GetVersionDetailResponse
    {
        $serverRequestInterface = $request->getServerRequestInterface($this->ocpiConfiguration->getServerRequestFactory());
        $responseInterface = $this->ocpiConfiguration->getHttpClient()->sendRequest($serverRequestInterface);
        return GetVersionDetailResponse::fromResponseInterface($responseInterface);
    }
}
