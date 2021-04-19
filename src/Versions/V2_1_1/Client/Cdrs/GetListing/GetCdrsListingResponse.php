<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CdrFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Cdr;
use Psr\Http\Message\ResponseInterface;

class GetCdrsListingResponse extends AbstractResponse
{
    private ?GetCdrsListingRequest $nextRequest;

    private ?GetCdrsListingRequest $previousRequest;

    /** @var Cdr[] */
    private array $cdrs = [];

    /**
     * @param GetCdrsListingRequest $request
     * @param ResponseInterface $response
     * @return GetCdrsListingResponse
     * @throws OcpiUnauthorizedException
     * @throws OcpiInvalidPayloadClientError
     */
    public static function from(GetCdrsListingRequest $request, ResponseInterface $response): GetCdrsListingResponse
    {
        if ($response->getStatusCode() === 401) {
            throw new OcpiUnauthorizedException();
        }

        $json = self::toJson($response, 'V2_1_1/eMSP/Client/CDRs/cdrGetResponse.schema.json');

        $return = new self();
        foreach ($json->data ?? [] as $item) {
            $return->cdrs[] = CdrFactory::fromJson($item);
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

    /** @return Cdr[] */
    public function getCdrs(): array
    {
        return $this->cdrs;
    }

    public function getNextRequest(): ?GetCdrsListingRequest
    {
        return $this->nextRequest;
    }

    public function getPreviousRequest(): ?GetCdrsListingRequest
    {
        return $this->previousRequest;
    }
}