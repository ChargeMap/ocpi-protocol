<?php
declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Versions\GetDetails\GetVersionDetailRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Versions\GetDetails\GetVersionDetailResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Versions\GetDetails\GetVersionDetailService;

class Versions extends AbstractFeatures
{
    public function getVersionDetail(GetVersionDetailRequest $request): GetVersionDetailResponse
    {
        return (new GetVersionDetailService($this->ocpiConfiguration))->get($request);
    }
}