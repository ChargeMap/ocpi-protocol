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

        $serverRequestInterface = $request->getServerRequestInterface($this->ocpiConfiguration->getServerRequestFactory(), $this->ocpiConfiguration->getStreamFactory());

        $uri = $serverRequestInterface->getUri()
            ->withPath($endpointUrl->getPath())
            ->withScheme($endpointUrl->getScheme())
            ->withHost($endpointUrl->getHost());

        if (!empty($endpointUrl->getPort())) {
            $uri = $uri->withPort($endpointUrl->getPort());
        }

        if (!empty($endpointUrl->getUserInfo())) {
            $uri = $uri->withUserInfo($endpointUrl->getUserInfo());
        }

        $serverRequestInterface = $serverRequestInterface->withUri($uri)->withHeader('Authorization', 'Token ' . $this->ocpiConfiguration->getToken());
        return $this->ocpiConfiguration->getHttpClient()->sendRequest($serverRequestInterface);
    }

}
