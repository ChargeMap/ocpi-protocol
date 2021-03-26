<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetDetails;

use Chargemap\OCPI\Common\Client\InvalidTokenException;
use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Common\Factories\OcpiEndpointFactory;
use Chargemap\OCPI\Common\Models\OcpiEndpoint;
use JsonException;
use Psr\Http\Message\ResponseInterface;

class GetVersionDetailResponse extends AbstractResponse
{
    /** @var OcpiEndpoint[] */
    private array $ocpiEndpoints = [];

    /**
     * @param ResponseInterface $response
     * @return static
     * @throws InvalidTokenException
     * @throws VersionDetailEndpointNotFoundException
     * @throws JsonException
     */
    public static function fromResponseInterface(ResponseInterface $response): self
    {
        if($response->getStatusCode() === 404) {
            throw new VersionDetailEndpointNotFoundException();
        }
        $responseAsJson = self::toJson($response, 'V2_1_1/eMSP/Client/Versions/versionGetDetailResponse.schema.json');


        if($response->getStatusCode() === 401 || $responseAsJson->status_code === 2002) {
            throw new InvalidTokenException();
        }

        $version = OcpiVersion::fromVersionNumber($responseAsJson->data->version);

        $result = new self();

        foreach ($responseAsJson->data->endpoints as $item) {
            $result->addEndpoint(OcpiEndpointFactory::fromJson($version, $item));
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
