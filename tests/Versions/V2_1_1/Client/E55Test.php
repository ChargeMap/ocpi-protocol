<?php

namespace Tests\Chargemap\OCPI\Client\Versions\V2_1_1;

use Chargemap\OCPI\Common\Client\OcpiClient;
use Chargemap\OCPI\Common\Client\OcpiConfiguration;
use Chargemap\OCPI\Common\Client\OcpiEndpoint;
use Chargemap\OCPI\Common\Client\OcpiModule;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingRequest;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;

class E55Test extends TestCase
{
    public function testConnectivity(): void
    {
        self::expectNotToPerformAssertions();

        $ocpiClient = new OcpiClient(
            (new OcpiConfiguration('TOCMP-OCPI-TOKEN-c7007237-94c4-4bd5-82ff-4af30a44233d'))
                ->withEndpoint(new OcpiEndpoint(OcpiVersion::V2_1_1(), OcpiModule::LOCATIONS(), new Uri('https://testing.e55c.com/ocpi/cpo/2.1.1/locations')))
        );

        $ocpiListingRequest = (new GetLocationsListingRequest())->withLimit(10)->withOffset(0);
        $ocpiListingResponse = $ocpiClient->V2_1_1()->locations()->getListing($ocpiListingRequest);

        // Loop to retrieve all location
        while (!empty(($locations = $ocpiListingResponse->getLocations()))) {
            if (($ocpiListingRequest = $ocpiListingResponse->getNextRequest()) === null) {
                break;
            }

            $ocpiListingResponse = $ocpiClient->V2_1_1()->locations()
                ->getListing($ocpiListingRequest);
        }
    }
}
