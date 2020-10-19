<?php


namespace Chargemap\OCPI\Versions\V2_1_1\Client;


use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get\GetTokenRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get\GetTokenResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get\GetTokenService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch\PatchTokenRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch\PatchTokenResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch\PatchTokenService;

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
}
