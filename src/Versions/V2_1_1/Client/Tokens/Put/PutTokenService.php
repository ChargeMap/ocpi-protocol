<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Put;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class PutTokenService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(PutTokenRequest $request): PutTokenResponse
    {
        $responseInterface = $this->sendRequest($request);
        return new PutTokenResponse($responseInterface);
    }
}