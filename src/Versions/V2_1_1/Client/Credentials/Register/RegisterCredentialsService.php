<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class RegisterCredentialsService extends AbstractFeatures
{
    public function handle(RegisterCredentialsRequest $request): RegisterCredentialsResponse
    {
        $responseInterface = $this->sendRequest($request);
        return RegisterCredentialsResponse::fromResponseInterface($responseInterface);
    }
}
