<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Post;

use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CredentialsFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Credentials;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class OcpiEmspCredentialsPostRequest extends OcpiUpdateRequest
{
    private Credentials $credentials;

    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct($request);
        PayloadValidation::coerce('V2_1_1/eMSP/Server/Credentials/credentialsPostRequest.schema.json', $this->jsonBody);
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
