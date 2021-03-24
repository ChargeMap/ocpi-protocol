<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetDetails;

use Chargemap\OCPI\Common\Client\InvalidTokenException;
use Chargemap\OCPI\Common\Client\OcpiEndpoint;
use Chargemap\OCPI\Common\Client\OcpiModule;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\ResponseInterface;

class GetVersionDetailResponse
{
    /** @var OcpiEndpoint[] */
    private array $ocpiEndpoints = [];

    public static function fromResponseInterface(ResponseInterface $response): self
    {
        if($response->getStatusCode() === 404) {
            throw new VersionDetailEndpointNotFoundException();
        }

        $responseAsJson = json_decode($response->getBody()->__toString(), false, 512, JSON_THROW_ON_ERROR);

        if($response->getStatusCode() === 401 || $responseAsJson->status_code === 2002) {
            throw new InvalidTokenException();
        }

        $version = OcpiVersion::fromVersionNumber($responseAsJson->data->version);

        $result = new self();

        foreach ($responseAsJson->data->endpoints as $item) {
            $endpoint = new OcpiEndpoint(
                $version,
                new OcpiModule($item->identifier),
                Psr17FactoryDiscovery::findUriFactory()->createUri($item->url)
            );
            $result->addEndpoint($endpoint);
        }

        return $result;
    }

    private function addEndpoint(OcpiEndpoint $endpoint): void
    {
        $this->ocpiEndpoints[] = $endpoint;
    }

    /** @return OcpiEndpoint[] */
    public function getOcpiEndpoints(): array
    {
        return $this->ocpiEndpoints;
    }
}
