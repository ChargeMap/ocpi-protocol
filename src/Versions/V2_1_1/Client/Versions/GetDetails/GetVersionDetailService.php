<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Versions\GetDetails;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetVersionDetailService extends AbstractFeatures
{
    public function get(GetVersionDetailRequest $request): GetVersionDetailResponse
    {
        $serverRequestInterface = $request->getServerRequestInterface($this->ocpiConfiguration->getServerRequestFactory());
        $serverRequestInterface = $this->addAuthorization($serverRequestInterface);
        $responseInterface = $this->ocpiConfiguration->getHttpClient()->sendRequest($serverRequestInterface);
        return GetVersionDetailResponse::fromResponseInterface($responseInterface);
    }
}
