<?php

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetDetails;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetVersionDetailService extends AbstractFeatures
{
    public function get(GetVersionDetailRequest $request): GetVersionDetailResponse
    {
        $requestInterface = $request->getRequestInterface($this->ocpiConfiguration->getRequestFactory());
        $responseInterface = $this->ocpiConfiguration->getHttpClient()->sendRequest($requestInterface);
        return GetVersionDetailResponse::fromResponseInterface($responseInterface);
    }
}
