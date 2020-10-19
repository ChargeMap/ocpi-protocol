<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Versions\Details\Get;

use Chargemap\OCPI\Common\Server\Models\VersionNumber;
use Chargemap\OCPI\Common\Server\OcpiSuccessResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Endpoint;
use InvalidArgumentException;

class OcpiEmspVersionDetailsGetResponse extends OcpiSuccessResponse
{
    private VersionNumber $versionNumber;

    /** @var Endpoint[] */
    private array $endpoints = [];

    public function __construct(VersionNumber $versionNumber, string $statusMessage = null)
    {
        parent::__construct(OcpiSuccessHttpCode::HTTP_OK(), $statusMessage);
        $this->versionNumber = $versionNumber;
    }

    public function addEndpoint(Endpoint $endpoint): self
    {
        $this->endpoints[] = $endpoint;

        return $this;
    }

    protected function getData(): array
    {
        if (count($this->endpoints) < 1) {
            throw new InvalidArgumentException('Version details response must contain at least 1 endpoint');
        }

        return [
            'version' => $this->versionNumber,
            'endpoints' => $this->endpoints,
        ];
    }
}