<?php

namespace Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Client\OcpiConfiguration;
use Psr\Http\Message\ResponseInterface;

class AbstractFeatures
{
    protected OcpiConfiguration $ocpiConfiguration;

    public function __construct(OcpiConfiguration $ocpiConfiguration)
    {
        $this->ocpiConfiguration = $ocpiConfiguration;
    }

    protected function sendRequest(AbstractRequest $request): ResponseInterface
    {
        $endpointUrl = $this->ocpiConfiguration->getEndpoint($request->getModule(), $request->getVersion())->getUri();

        $requestInterface = $request->getRequestInterface($this->ocpiConfiguration->getRequestFactory(), $this->ocpiConfiguration->getStreamFactory());

        $uri = $requestInterface->getUri()
            ->withPath($endpointUrl->getPath())
            ->withScheme($endpointUrl->getScheme())
            ->withHost($endpointUrl->getHost());

        if (!empty($endpointUrl->getPort())) {
            $uri = $uri->withPort($endpointUrl->getPort());
        }

        if (!empty($endpointUrl->getUserInfo())) {
            $uri = $uri->withUserInfo($endpointUrl->getUserInfo());
        }

        $requestInterface = $requestInterface->withUri($uri)->withHeader('Authorization', 'Token ' . $this->ocpiConfiguration->getToken());
        return $this->ocpiConfiguration->getHttpClient()->sendRequest($requestInterface);
    }

}
