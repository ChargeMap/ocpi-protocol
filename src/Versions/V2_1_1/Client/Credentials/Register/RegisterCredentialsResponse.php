<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Common\Client\Modules\Credentials\Register\ClientAlreadyRegisteredException;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CredentialsFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Credentials;
use Psr\Http\Message\ResponseInterface;

class RegisterCredentialsResponse extends AbstractResponse
{
    private Credentials $credentials;

    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    public static function fromResponseInterface(ResponseInterface $response): self
    {
        if ($response->getStatusCode() === 405) {
            throw new ClientAlreadyRegisteredException();
        }

        $json = self::toJson($response, __DIR__ . '/../../Schemas/postCredentialsResponse.schema.json');

        return new self(CredentialsFactory::fromJson($json->data));
    }

    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }
}