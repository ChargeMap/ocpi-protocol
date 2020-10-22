<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

abstract class OcpiListingResponse extends OcpiSuccessResponse
{
    protected int $totalCount;
    protected int $limit;
    private OcpiListingRequest $listingRequest;

    public function __construct(OcpiListingRequest $listingRequest, int $totalCount, int $limit, string $statusMessage = null)
    {
        parent::__construct(OcpiSuccessHttpCode::HTTP_OK(), $statusMessage);
        $this->listingRequest = $listingRequest;
        $this->totalCount = $totalCount;
        $this->limit = $limit;
    }

    public function getResponseInterface(ResponseFactoryInterface $responseFactory = null, StreamFactoryInterface $streamFactory = null): ResponseInterface
    {
        if ($responseFactory === null) {
            $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        }

        if ($streamFactory === null) {
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        $response = parent::getResponseInterface($responseFactory, $streamFactory)
            ->withHeader('X-Total-Count', $this->totalCount)
            ->withHeader('X-Limit', $this->limit);

        $uri = $this->listingRequest->getRawRequest()->getUri();
        $query = $this->listingRequest->getRawRequest()->getQueryParams();

        $offset = $query['offset'] ?? 0;
        if ($offset + $this->limit < $this->totalCount) {
            $query['offset'] = $offset + $this->limit;

            $uri = $uri
                ->withQuery(http_build_query($query))
                ->withPort(null)
                ->withScheme('https');
            $response = $response->withHeader('Link', $uri->__toString());
        }

        return $response;
    }
}
