<?php

namespace Chargemap\OCPI\Common\Server;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

abstract class OcpiListingRequest extends OcpiBaseRequest
{
    private ?int $offset;

    private ?int $limit;

    public function __construct(ServerRequestInterface $request)
    {
        $params = $request->getQueryParams();

        $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : null;
        $limit = array_key_exists('limit', $params) ? (int)$params['limit'] : null;

        if ($offset !== null && $offset < 0) {
            throw new InvalidArgumentException(sprintf('Offset %d can not be negative value.', $offset));
        }

        if ($limit !== null && $limit < 0) {
            throw new InvalidArgumentException(sprintf('Limit %d can not be negative value.', $limit));
        }

        parent::__construct($request);
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
