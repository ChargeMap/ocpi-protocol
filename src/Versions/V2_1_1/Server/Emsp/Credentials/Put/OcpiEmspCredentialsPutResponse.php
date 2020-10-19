<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Put;

use Chargemap\OCPI\Common\Server\OcpiUpdateResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Credentials;

class OcpiEmspCredentialsPutResponse extends OcpiUpdateResponse
{
    private Credentials $credentials;

    public function __construct(Credentials $credentials, string $statusMessage = null)
    {
        parent::__construct($statusMessage);
        $this->credentials = $credentials;
    }

    protected function getData(): Credentials
    {
        return $this->credentials;
    }
}
