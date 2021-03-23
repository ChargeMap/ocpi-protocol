<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class RegisterCredentialsService extends AbstractFeatures
{
    public function handle(RegisterCredentialsRequest $request): RegisterCredentialsResponse
    {
        $serverRequestInterface = $request->getServerRequestInterface($this->ocpiConfiguration->getServerRequestFactory(), $this->ocpiConfiguration->getStreamFactory());
        $responseInterface = $this->ocpiConfiguration->getHttpClient()->sendRequest($serverRequestInterface);
        return RegisterCredentialsResponse::fromResponseInterface($responseInterface);
    }
}
