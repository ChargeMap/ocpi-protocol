<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Utils;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use JsonSchema\Validator;
use stdClass;

final class PayloadValidation
{
    /**
     * @param string $schemaPath
     * @param stdClass $object
     * @throws OcpiInvalidPayloadClientError
     */
    public static function coerce(string $schemaPath, stdClass $object): void
    {
        $jsonSchemaValidation = new Validator();
        $schemasPath = __DIR__ . '/../../../resources/jsonSchemas';
        $jsonSchemaValidation->coerce(
            $object,
            (object)['$ref' => 'file://' . realpath($schemasPath) . DIRECTORY_SEPARATOR . $schemaPath]
        );
        if (!$jsonSchemaValidation->isValid()) {
            throw new OcpiInvalidPayloadClientError(sprintf('Payload does not validate %s', basename($schemaPath)));
        }
    }
}
