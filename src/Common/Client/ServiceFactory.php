<?php

namespace Chargemap\OCPI\Common\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get\GetTokenRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get\GetTokenService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Put\PutTokenRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Put\PutTokenService;
use UnexpectedValueException;

final class ServiceFactory
{
    public static function from(AbstractRequest $request, OcpiConfiguration $configuration): AbstractFeatures
    {
        switch ($request->getVersion()->getValue()) {
            case OcpiVersion::V2_1_1:
                if (get_class($request) === GetLocationsListingRequest::class) {
                    return new GetLocationsListingService($configuration);
                }
                if (get_class($request) === GetTokenRequest::class) {
                    return new GetTokenService($configuration);
                }
                if (get_class($request) === PutTokenRequest::class) {
                    return new PutTokenService($configuration);
                }
                break;
        }

        throw new UnexpectedValueException(sprintf('Could not find service to handle %s class request', get_class($request)));
    }
}
