<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Common\Factories\VersionEndpointFactory;
use Chargemap\OCPI\Common\Models\VersionEndpoint;
use Chargemap\OCPI\Common\Server\Errors\OcpiGenericClientError;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidTokenClientError;
use JsonException;
use Psr\Http\Message\ResponseInterface;

class GetAvailableVersionsResponse extends AbstractResponse
{
    /** @var VersionEndpoint[] */
    private array $versions = [];

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

        $responseAsJson = self::toJson($response, 'eMSP/Client/Versions/versionGetAvailableResponse.schema.json');


        if($response->getStatusCode() === 401 || $responseAsJson->status_code === 2002) {
            //TODO reorganize namespace
            throw new OcpiInvalidTokenClientError();
        }

        $result = new self();

        foreach ($responseAsJson->data as $item) {
            $result->versions[] = VersionEndpointFactory::fromJson($item);
        }

        return $result;
    }

    /** @return VersionEndpoint[] */
    public function getVersions(): array
    {
        return $this->versions;
    }
}
