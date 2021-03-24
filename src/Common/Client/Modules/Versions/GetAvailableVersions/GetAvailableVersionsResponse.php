<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions;

use Chargemap\OCPI\Common\Client\OcpiVersion;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\ResponseInterface;

class GetAvailableVersionsResponse
{
    /** @var VersionEndpoint[] */
    private array $versions = [];

    public static function fromResponseInterface(ResponseInterface $response): self
    {
        if($response->getStatusCode() === 404) {
            throw new VersionsEndpointNotFoundException();
        }

        $responseAsJson = json_decode($response->getBody()->__toString(), false, 512, JSON_THROW_ON_ERROR);

        if($response->getStatusCode() === 401 || $responseAsJson->status_code === 2002) {
            throw new InvalidTokenException();
        }

        $result = new self();

        foreach ($responseAsJson->data as $item) {
            $result->versions[] = new VersionEndpoint(
                OcpiVersion::fromVersionNumber($item->version),
                Psr17FactoryDiscovery::findUriFactory()->createUri($item->url)
            );
        }

        return $result;
    }

    /** @return VersionEndpoint[] */
    public function getVersions(): array
    {
        return $this->versions;
    }
}
