<?php

namespace Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidTokenClientError;
use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Psr\Http\Message\RequestInterface;

abstract class OcpiBaseRequest
{
    private string $authorization;

    private RequestInterface $rawRequest;

    public function __construct(RequestInterface $request)
    {
        $this->authorization = self::extractAuthorization($request);
        $this->rawRequest = $request;
    }

    public static function extractAuthorization(RequestInterface $request): string
    {
        if (empty($request->getHeader('Authorization'))) {
            throw new OcpiNotEnoughInformationClientError('Authorization header should be provided');
        }

        $token = trim($request->getHeader('Authorization')[0]);

        if (!preg_match('%^Token ([!-~]+)$%', $token, $matches)) {
            throw new OcpiInvalidTokenClientError('Invalid token: should consist of printable, non-whitespace characters.');
        }

        return $matches[1];
    }

    public function getAuthorization(): string
    {
        return $this->authorization;
    }

    public function getRawRequest(): RequestInterface
    {
        return $this->rawRequest;
    }
}
