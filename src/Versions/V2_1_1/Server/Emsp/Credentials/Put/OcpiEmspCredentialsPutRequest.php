<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Put;

use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CredentialsFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Credentials;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class OcpiEmspCredentialsPutRequest extends OcpiUpdateRequest
{
    private Credentials $credentials;

    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct($request);
        PayloadValidation::coerce('Versions/V2_1_1/Server/Emsp/Schemas/credentialsPost.schema.json', $this->jsonBody);
        $credentials = CredentialsFactory::fromJson($this->jsonBody);
        if ($credentials === null) {
            throw new UnexpectedValueException('Credentials cannot be null');
        }
        $this->credentials = $credentials;
    }

    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }
}
