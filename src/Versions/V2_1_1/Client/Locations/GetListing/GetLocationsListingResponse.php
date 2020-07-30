<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location;
use Psr\Http\Message\ResponseInterface;

class GetLocationsListingResponse extends AbstractResponse
{
    private ?GetLocationsListingRequest $nextRequest;

    private ?GetLocationsListingRequest $previousRequest;

    /** @var Location[] */
    private array $locations = [];

    public static function from(GetLocationsListingRequest $request, ResponseInterface $response): GetLocationsListingResponse
    {
        $json = self::toJson($response);
        $return = new self();

        foreach ($json->data as $item) {
            self::validate($item, __DIR__ . '/../../Schemas/location.schema.json');
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
