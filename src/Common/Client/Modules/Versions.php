<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions\GetAvailableVersionsRequest;
use Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions\GetAvailableVersionsResponse;
use Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions\GetAvailableVersionsService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Versions\GetDetails\GetVersionDetailRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Versions\GetDetails\GetVersionDetailResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Versions\GetDetails\GetVersionDetailService;
use InvalidArgumentException;

class Versions extends AbstractFeatures
{
    public function getAvailableVersions(): GetAvailableVersionsResponse
    {
        if (($versionEndpoint = $this->ocpiConfiguration->getVersionEndpoint()) === null) {
            throw new InvalidArgumentException(sprintf('Versions endpoint must be specified in configuration to call this service.'));
        }

        $getVersionsRequest = new GetAvailableVersionsRequest($versionEndpoint->__toString());
        return (new GetAvailableVersionsService($this->ocpiConfiguration))->get($getVersionsRequest);
    }
}
