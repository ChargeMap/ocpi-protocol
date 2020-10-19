<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get\GetTokenRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get\GetTokenResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get\GetTokenService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch\PatchTokenRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch\PatchTokenResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch\PatchTokenService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Put\PutTokenRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Put\PutTokenResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Put\PutTokenService;

class Tokens extends AbstractFeatures
{
    public function get(GetTokenRequest $request): GetTokenResponse
    {
        return (new GetTokenService($this->ocpiConfiguration))->handle($request);
    }

    public function patch(PatchTokenRequest $request): PatchTokenResponse
    {
        return (new PatchTokenService($this->ocpiConfiguration))->handle($request);
    }

    public function put(PutTokenRequest $request): PutTokenResponse
    {
        return (new PutTokenService($this->ocpiConfiguration))->handle($request);
    }
}
