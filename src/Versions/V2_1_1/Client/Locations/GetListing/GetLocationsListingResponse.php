<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing;

use Chargemap\OCPI\Common\Client\Modules\Locations\GetListing\GetLocationsListingResponse as BaseResponse;
use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location;
use Psr\Http\Message\ResponseInterface;

class GetLocationsListingResponse extends BaseResponse
{
    private ?GetLocationsListingRequest $nextRequest;

    /** @var Location[] */
    private array $locations = [];

    /**
     * @param GetLocationsListingRequest $request
     * @param ResponseInterface $response
     * @return GetLocationsListingResponse
     * @throws OcpiUnauthorizedException
     * @throws OcpiInvalidPayloadClientError
     */
    public static function from(GetLocationsListingRequest $request, ResponseInterface $response): GetLocationsListingResponse
    {
        if($response->getStatusCode() === 401) {
            throw new OcpiUnauthorizedException();
        }

        $json = self::toJson($response, 'V2_1_1/eMSP/Client/Locations/locationGetListingResponse.schema.json');

        $return = new self();
        foreach ($json->data ?? [] as $item) {
            $return->locations[] = LocationFactory::fromJson($item);
        }

        $nextRequest = null;

        $nextOffset = $request->getNextOffset($response);
        $nextLimit = $request->getNextLimit($response);

        if ($nextOffset !== null) {
            $nextRequest = (clone $request)->withOffset($nextOffset);

            if($nextLimit !== null) {
                $nextRequest = $nextRequest->withLimit($nextLimit);
            }
        }

        $return->nextRequest = $nextRequest;

        return $return;
    }

    /** @return Location[] */
    public function getLocations(): array
    {
        return $this->locations;
    }

    public function getNextRequest(): ?GetLocationsListingRequest
    {
        return $this->nextRequest;
    }
}
