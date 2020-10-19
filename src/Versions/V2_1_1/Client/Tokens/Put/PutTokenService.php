<?php


namespace Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Put;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class PutTokenService extends AbstractFeatures
{
    public function handle(PutTokenRequest $request): PutTokenResponse
    {
        $responseInterface = $this->sendRequest($request);
        return new PutTokenResponse($responseInterface);
    }
}