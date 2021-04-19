<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class RegisterCredentialsService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\Modules\Credentials\Register\ClientAlreadyRegisteredException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     */
    public function handle(RegisterCredentialsRequest $request): RegisterCredentialsResponse
    {
        $responseInterface = $this->sendRequest($request);
        return RegisterCredentialsResponse::fromResponseInterface($responseInterface);
    }
}
