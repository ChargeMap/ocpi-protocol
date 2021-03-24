<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetAvailableVersionsService extends AbstractFeatures
{
    public function get(GetAvailableVersionsRequest $request): GetAvailableVersionsResponse
    {
        $serverRequestInterface = $request->getServerRequestInterface($this->ocpiConfiguration->getServerRequestFactory());
        $serverRequestInterface = $this->addAuthorization($serverRequestInterface);
        $responseInterface = $this->sendRequest($serverRequestInterface);
        return GetAvailableVersionsResponse::fromResponseInterface($responseInterface);
    }
}
