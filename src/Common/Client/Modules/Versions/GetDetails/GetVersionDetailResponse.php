<?php

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetDetails;

use Chargemap\OCPI\Common\Client\OcpiEndpoint;
use Chargemap\OCPI\Common\Client\OcpiModule;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use League\Uri\Uri;
use Psr\Http\Message\ResponseInterface;

class GetVersionDetailResponse
{
    /** @var OcpiEndpoint[] */
    private array $ocpiEndpoints = [];

    public static function fromResponseInterface(ResponseInterface $response): self
    {
        $responseAsJson = json_decode($response->getBody()->__toString());
        $version = OcpiVersion::fromVersionNumber($responseAsJson->version);

        $response = new self();
        foreach ($responseAsJson->modules as $item) {
            $response->ocpiEndpoints[] = new OcpiEndpoint(
                $version,
                new OcpiModule($item->identifier),
                Uri::createFromString($item->url)
            );
        }

        return $responseAsJson;
    }

    /** @return OcpiEndpoint[] */
    public function getOcpiEndpoints(): array
    {
        return $this->ocpiEndpoints;
    }
}
