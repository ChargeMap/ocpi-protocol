<?php

namespace Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Client\Modules\Tokens\Get\GetTokenRequest;
use Chargemap\OCPI\Common\Client\Modules\Tokens\Get\GetTokenResponse;
use Chargemap\OCPI\Common\Client\Modules\Tokens\Get\GetTokenService;
use Chargemap\OCPI\Common\Client\Modules\Tokens\Patch\PatchTokenRequest;
use Chargemap\OCPI\Common\Client\Modules\Tokens\Patch\PatchTokenResponse;
use Chargemap\OCPI\Common\Client\Modules\Tokens\Patch\PatchTokenService;

class Tokens extends AbstractFeatures
{
    private GetTokenService $tokenService;

    private PatchTokenService $patchTokenService;

    public function get(GetTokenRequest $request): GetTokenResponse
    {
        if ($this->tokenService === null) {
            $this->tokenService = new GetTokenService($this->ocpiConfiguration);
        }

        return $this->tokenService->handle($request);
    }

    public function patch(PatchTokenRequest $request): PatchTokenResponse
    {
        if ($this->patchTokenService === null) {
            $this->patchTokenService = new PatchTokenService($this->ocpiConfiguration);
        }

        return $this->patchTokenService->handle($request);
    }
}
