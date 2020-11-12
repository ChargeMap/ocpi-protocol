<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetCdrsListingService extends AbstractFeatures
{
    public function handle(GetCdrsListingRequest $request): GetCdrsListingResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetCdrsListingResponse::from($request, $responseInterface);
    }
}