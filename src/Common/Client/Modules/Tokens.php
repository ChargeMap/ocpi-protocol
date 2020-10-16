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
    private GetTokenService $GetTokenService;
    private PutTokenService $PutTokenService;

    public function get(GetTokenRequest $request): GetTokenResponse
    {
        if ($this->GetTokenService === null) {
            $this->GetTokenService = new GetTokenService($this->ocpiConfiguration);
        }

        return $this->GetTokenService->handle($request);
    }

    public function put(PutTokenRequest $request): PutTokenResponse
    {
        if ($this->PutTokenService === null) {
            $this->PutTokenService = new PutTokenService($this->ocpiConfiguration);
        }

        return $this->PutTokenService->handle($request);
    }
}
