<?php

namespace Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Client\Modules\Tokens\Get\GetTokenRequest;
use Chargemap\OCPI\Common\Client\Modules\Tokens\Get\GetTokenResponse;
use Chargemap\OCPI\Common\Client\Modules\Tokens\Get\GetTokenService;

class Tokens extends AbstractFeatures
{
    private GetTokenService $tokenService;

    public function get(GetTokenRequest $request): GetTokenResponse
    {
        if ($this->tokenService === null) {
            $this->tokenService = new GetTokenService($this->ocpiConfiguration);
        }

        return $this->tokenService->handle($request);
    }
}
