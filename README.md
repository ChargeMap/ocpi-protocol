#OCPI Protocol
Library to handle OCPI. Compatible with PSRs.

##Functionality
Library provides OCPI request/response classes for eMSP interfaces, models, factories and errors.
Listing requests/responses are also supported for GET routes.
The responses need a corresponding request to be constructed.
It is required to ensure the presence and validity of
__offset__ and __limit__ request headers and
__X-Total-Count__, __X-Limit__ and __Link__ response headers.
So it is quite easy to construct valid listing response or get the next request.
##eMSP interface
###Respond to CPO
```php
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Put\OcpiEmspSessionPutRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Put\OcpiEmspSessionPutResponse;

$sessionPutRequest = new OcpiEmspSessionPutRequest($httpRequest, $countryCode, $partyId, $sessionId);
$session = $sessionPutRequest->getSession();

// Some code...

$sessionPutResponse = new OcpiEmspSessionPutResponse($session);
$response = $sessionPutResponse->getResponseInterface();
```
Each request and response class correspond to an eMSP interface route.
Request classes must be instantiated by providing PSR-7 compatible request (got from CPO).
Internally, it extracts the authorization token from headers, and validates the body (if necessary) against json schema.
Then, it constructs corresponding model class using the factories.
The model is accessible via a getter.

Response classes must be instantiated with a model instance, even if it's not used (e.g. in Post/Put/Patch responses).
It can be converted to PSR-7 compatible response instance using *getResponseInterface* method.
####Use of listing request/response
```php
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get\OcpiEmspTokenGetRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get\OcpiEmspTokenGetResponse;

$tokenGetRequest = new OcpiEmspTokenGetRequest($httpRequest);
$tokens = [];
$tokenCount = 0;

//Fetch tokens from database...

$tokenGetResponse = new OcpiEmspTokenGetResponse($tokenGetRequest, $tokenCount, count($tokens));
foreach ($items as $item) {
    $tokenGetResponse->addToken($item);
}
// X-Total-Count, X-Limit and Link headers are already set in $response
$response = $tokenGetResponse->getResponseInterface();
```

###Request the CPO
This part provides an API SDK to request the CPO. To use it, you need to instantiate the OcpiClient
with OcpiConfiguration and needed endpoints. Then you can perform the requests like that:
```php
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingRequest;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location;
use Chargemap\OCPI\Common\Client\OcpiClient;
use Chargemap\OCPI\Common\Client\OcpiConfiguration;
use Chargemap\OCPI\Common\Client\OcpiEndpoint;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Common\Client\OcpiModule;

$getLocationListingRequest = (new GetLocationsListingRequest())
                                ->withOffset(0)
                                ->withLimit(100)
                                ->withDateFrom($dateFrom)
                                ->withDateTo($dateTo);
$ocpiClient = new OcpiClient(
            (new OcpiConfiguration($supervisorAuthString))
                ->withEndpoint(new OcpiEndpoint(
                    OcpiVersion::V2_1_1(),
                    OcpiModule::LOCATIONS(),
                    new Uri('ocpi/cpo2.0/locations'))
                )
        );
$locationResponse = $ocpiClient->V2_1_1()->locations()->getListing($getLocationListingRequest);
/** @var Location[] $locations */
$locations = $locationResponse->getLocations();
//Some code...
```
####Listing request/response
```php
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingRequest;
use Chargemap\OCPI\Common\Client\OcpiClient;
use Chargemap\OCPI\Common\Client\OcpiConfiguration;
use Chargemap\OCPI\Common\Client\OcpiEndpoint;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Common\Client\OcpiModule;

$ocpiClient = new OcpiClient(
            (new OcpiConfiguration($supervisorAuth))
                ->withEndpoint(new OcpiEndpoint(
                    OcpiVersion::V2_1_1(),
                    OcpiModule::LOCATIONS(),
                    new Uri('ocpi/cpo2.0/locations'))
                )
        );
$getLocationListingRequest = (new GetLocationsListingRequest())
                                ->withOffset(0)
                                ->withLimit(100)
                                ->withDateFrom($dateFrom)
                                ->withDateTo($dateTo);
do {
    $locationResponse = $this->ocpiClient->V2_1_1()->locations()->getListing($getLocationListingRequest);
    
    //Some code...     
    
    //Next request will update its limit and offset values
    $getLocationListingRequest = $locationResponse->getNextRequest();
} while ($getLocationListingRequest !== null);
```
###Common
####Errors
Each error class corresponds to an OCPI error code.
It can be converted to the PSR-7 response instance just like any response class.
It ensures correct HTTP error code as well as OCPI status code.

```php
use Chargemap\OCPI\Common\Server\Errors\OcpiGenericClientError;

$error = new OcpiGenericClientError('Client error');
//Correct payload and HTTP error code is already set
$response = $error->getResponseInterface();
```

Errors are supposed to be thrown and caught by a middleware/listener and then transformed to the response.

####Models
Models fetched from request's/response's json body correspond to the OCPI objects.
The exception to the rule is Partial[Class] classes, that are used in PATCH routes.
They have the same but nullable properties as their corresponding [Class].
