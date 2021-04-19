<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetAvailableVersionsService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiGenericClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidTokenClientError
     */
    public function get(GetAvailableVersionsRequest $request): GetAvailableVersionsResponse
    {
        $serverRequestInterface = $request->getServerRequestInterface($this->ocpiConfiguration->getServerRequestFactory());
        $serverRequestInterface = $this->addAuthorization($serverRequestInterface);
        $responseInterface = $this->ocpiConfiguration->getHttpClient()->sendRequest($serverRequestInterface);
        return GetAvailableVersionsResponse::fromResponseInterface($responseInterface);
    }
}
