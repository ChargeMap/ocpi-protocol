<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules;

use Psr\Http\Message\ResponseInterface;
use UnexpectedValueException;

trait ListingRequest
{
    private ?int $offset;

    private ?int $limit;

    public function withOffset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function withLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function getNextOffset(ResponseInterface $response): ?int
    {
        return $this->getUriParameter('offset', $response);
    }

    public function getNextLimit(ResponseInterface $response): ?int
    {
        $limit = $this->getUriParameter('limit', $response);

        if($limit === 0) {
            $limit = null;
        }

        return $limit;
    }

    private function getUriParameter(string $parameterName, ResponseInterface $response): ?int
    {
        $headers = $response->getHeader('Link');

        if($headers === null || count($headers) === 0) {
            return null;
        }

        if(count($headers) > 1) {
            throw new UnexpectedValueException('More than one "Link" header found');
        }

        if( preg_match( '%^<(.*?)>\s*;\s*rel\s*=\s*["\']next["\']\s*$%', $headers[0], $matches) !== 1 ) {
            throw new UnexpectedValueException($headers[0].' does not match the pattern %^<(.*?)>\s*;\s*rel\s*=\s*["\']next["\']\s*$%' );
        }

        $queryString = parse_url($matches[1], PHP_URL_QUERY);

        if($queryString === null) {
            return null;
        }

        parse_str($queryString, $parameters);

        if($parameters === null || !array_key_exists($parameterName, $parameters)) {
            return null;
        }

        if(preg_match('%[0-9]*%', $parameters[$parameterName]) !== 1) {
            throw new UnexpectedValueException($parameters[$parameterName].' does not look like an integer');
        }

        return intval($parameters[$parameterName]);
    }
}
