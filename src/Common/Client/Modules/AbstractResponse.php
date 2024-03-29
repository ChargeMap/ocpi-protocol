<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use JsonException;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractResponse
{
    /**
     * @param ResponseInterface $response
     * @param string|null $schemaPath
     * @return mixed
     * @throws OcpiInvalidPayloadClientError
     */
    protected static function toJson(ResponseInterface $response, string $schemaPath = null)
    {
        try {
            $jsonObject = json_decode($response->getBody()->__toString(), false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new OcpiInvalidPayloadClientError('Received payload is not valid JSON');
        }
        if ($schemaPath !== null) {
            PayloadValidation::coerce($schemaPath, $jsonObject);
        }

        return $jsonObject;
    }
}
