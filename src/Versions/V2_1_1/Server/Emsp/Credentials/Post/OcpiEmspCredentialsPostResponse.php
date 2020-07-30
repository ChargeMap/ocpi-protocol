<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Post;

use Chargemap\OCPI\Common\Server\OcpiCreateResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Credentials;

class OcpiEmspCredentialsPostResponse extends OcpiCreateResponse
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
