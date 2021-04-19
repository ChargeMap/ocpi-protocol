<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetLocationService extends AbstractFeatures
{
    /**
     * @param GetLocationRequest $request
     * @return GetLocationResponse
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Client\OcpiUnauthorizedException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(GetLocationRequest $request): GetLocationResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetLocationResponse::from($responseInterface);
    }
}
