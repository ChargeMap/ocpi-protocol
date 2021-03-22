<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing;

use Chargemap\OCPI\Common\Client\Modules\Locations\GetListing\GetLocationsListingResponse as BaseResponse;
use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location;
use JsonException;
use Psr\Http\Message\ResponseInterface;

class GetLocationsListingResponse extends BaseResponse
{
    private ?GetLocationsListingRequest $nextRequest;

    private ?GetLocationsListingRequest $previousRequest;

    /** @var Location[] */
    private array $locations = [];

    /**
     * @param GetLocationsListingRequest $request
     * @param ResponseInterface $response
     * @return GetLocationsListingResponse
     * @throws OcpiUnauthorizedException
     * @throws JsonException
     */
    public static function from(GetLocationsListingRequest $request, ResponseInterface $response): GetLocationsListingResponse
    {
        if($response->getStatusCode() === 401) {
            throw new OcpiUnauthorizedException();
        }

        $json = self::toJson($response);
        self::validate($json, 'Locations/locationGetListingResponse.schema.json');

        $return = new self();
        foreach ($json->data ?? [] as $item) {
            $return->locations[] = LocationFactory::fromJson($item);
        }

        $totalCount = (int)$response->getHeader('X-Total-Count')[0];

        $nextRequest = null;
        if (($nextOffset = $request->nextOffset($totalCount)) !== null) {
            $nextRequest = (clone $request)->withOffset($nextOffset);
        }

        $previousRequest = null;
        if (($previousOffset = $request->previousOffset()) !== null) {
            $previousRequest = (clone $request)->withOffset($previousOffset);
        }

        $return->nextRequest = $nextRequest;
        $return->previousRequest = $previousRequest;

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

    public function getPreviousRequest(): ?GetLocationsListingRequest
    {
        return $this->previousRequest;
    }
}
