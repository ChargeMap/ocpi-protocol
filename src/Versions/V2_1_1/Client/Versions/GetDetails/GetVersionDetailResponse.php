<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Versions\GetDetails;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Common\Server\Errors\OcpiGenericClientError;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidTokenClientError;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\EndpointFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Endpoint;
use JsonException;
use Psr\Http\Message\ResponseInterface;

class GetVersionDetailResponse extends AbstractResponse
{
    private OcpiVersion $version;

    /** @var Endpoint[] */
    private array $endpoints = [];

    public function __construct(OcpiVersion $version)
    {
        $this->version = $version;
    }

    public function getVersion(): OcpiVersion
    {
        return $this->version;
    }

    /**
     * @param ResponseInterface $response
     * @return static
     * @throws JsonException
     */
    public static function fromResponseInterface(ResponseInterface $response): self
    {
        if($response->getStatusCode() === 404) {
            throw new OcpiGenericClientError('Url was not found');
        }

        if($response->getStatusCode() === 401) {
            throw new OcpiInvalidTokenClientError();
        }

        $responseAsJson = self::toJson($response, 'V2_1_1/eMSP/Client/Versions/versionGetDetailResponse.schema.json');

        if($responseAsJson->status_code === 2002) {
            throw new OcpiInvalidTokenClientError();
        }

        $version = OcpiVersion::fromVersionNumber($responseAsJson->data->version);

        $result = new self($version);

        foreach ($responseAsJson->data->endpoints as $item) {
            $result->addEndpoint(EndpointFactory::fromJson($item));
        }

        return $result;
    }

    private function addEndpoint(Endpoint $endpoint): void
    {
        $this->endpoints[] = $endpoint;
    }

    /** @return Endpoint[] */
    public function getEndpoints(): array
    {
        return $this->endpoints;
    }
}
