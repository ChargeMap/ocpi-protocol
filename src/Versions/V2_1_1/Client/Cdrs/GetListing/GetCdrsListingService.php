<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetCdrsListingService extends AbstractFeatures
{
    /**
     * @param \Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing\GetCdrsListingRequest $request
     * @return \Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing\GetCdrsListingResponse
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Client\OcpiUnauthorizedException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(GetCdrsListingRequest $request): GetCdrsListingResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetCdrsListingResponse::from($request, $responseInterface);
    }
}