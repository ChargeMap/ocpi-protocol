<?php

namespace Chargemap\OCPI\Common\Server\GetAll;

use Chargemap\OCPI\Common\Server\Errors\OcpiGenericServerError;
use Chargemap\OCPI\Common\Server\Models\Version;
use Chargemap\OCPI\Common\Server\OcpiSuccessResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;

class OcpiGetAllVersionsResponse extends OcpiSuccessResponse
{
    /** @var Version[] */
    private array $versions;

    public function __construct(string $statusMessage = null)
    {
        parent::__construct(OcpiSuccessHttpCode::HTTP_OK(), $statusMessage);
    }

    public function addVersion(Version $version): self
    {
        $this->versions[] = $version;
        return $this;
    }

    public function getData(): array
    {
        if (count($this->versions) < 1) {
            throw new OcpiGenericServerError('Versions response must contain at least 1 version object');
        }
        return $this->versions;
    }
}
