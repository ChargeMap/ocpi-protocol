<?php
declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsService;

class Credentials extends AbstractFeatures
{
    private ?RegisterCredentialsService $registerCredentialsService = null;

    /**
     * @throws \Chargemap\OCPI\Common\Client\Modules\Credentials\Register\ClientAlreadyRegisteredException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     */
    public function register(RegisterCredentialsRequest $request): RegisterCredentialsResponse
    {
        if($this->registerCredentialsService === null) {
            $this->registerCredentialsService = new RegisterCredentialsService($this->ocpiConfiguration);
        }

        return $this->registerCredentialsService->handle($request);
    }
}