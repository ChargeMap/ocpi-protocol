<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetTokenService extends AbstractFeatures
{
    public function handle(GetTokenRequest $request): GetTokenResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetTokenResponse::from($responseInterface);
    }
}
