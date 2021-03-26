<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions;

use Chargemap\OCPI\Common\Client\InvalidTokenException;
use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Common\Factories\VersionEndpointFactory;
use Chargemap\OCPI\Common\Models\VersionEndpoint;
use JsonException;
use Psr\Http\Message\ResponseInterface;

class GetAvailableVersionsResponse extends AbstractResponse
{
    /** @var VersionEndpoint[] */
    private array $versions = [];

    /**
     * @param ResponseInterface $response
     * @return static
     * @throws InvalidTokenException
     * @throws VersionsEndpointNotFoundException
     * @throws JsonException
     */
    public static function fromResponseInterface(ResponseInterface $response): self
    {
        if($response->getStatusCode() === 404) {
            throw new VersionsEndpointNotFoundException();
        }

        $responseAsJson = self::toJson($response, 'V2_1_1/eMSP/Client/Versions/versionGetAvailableResponse.schema.json');


        if($response->getStatusCode() === 401 || $responseAsJson->status_code === 2002) {
            throw new InvalidTokenException();
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
