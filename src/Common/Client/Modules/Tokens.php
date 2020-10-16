<?php

namespace Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Client\Modules\Tokens\Get\GetTokenRequest;
use Chargemap\OCPI\Common\Client\Modules\Tokens\Get\GetTokenResponse;
use Chargemap\OCPI\Common\Client\Modules\Tokens\Get\GetTokenService;
use Chargemap\OCPI\Common\Client\Modules\Tokens\Put\PutTokenRequest;
use Chargemap\OCPI\Common\Client\Modules\Tokens\Put\PutTokenResponse;
use Chargemap\OCPI\Common\Client\Modules\Tokens\Put\PutTokenService;

class Tokens extends AbstractFeatures
{
    private GetTokenService $getTokenService;
    private PutTokenService $putTokenService;

    public function get(GetTokenRequest $request): GetTokenResponse
    {
        if ($this->getTokenService === null) {
            $this->getTokenService = new GetTokenService($this->ocpiConfiguration);
        }

        return $this->getTokenService->handle($request);
    }

    public function put(PutTokenRequest $request): PutTokenResponse
    {
        if ($this->putTokenService === null) {
            $this->putTokenService = new PutTokenService($this->ocpiConfiguration);
        }

        return $this->putTokenService->handle($request);
    }
}
