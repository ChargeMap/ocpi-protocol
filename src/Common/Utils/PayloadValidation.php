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
            $errors = [];
            foreach ($jsonSchemaValidation->getErrors() as $error) {
                $errors[] = "property: " . $error['property'] . ', error: ' . $error['message'] . '. ';
            }
            throw new OcpiInvalidPayloadClientError(sprintf('Payload does not validate %s. Issues: %s',
                basename($schemaPath), implode($errors)));
        }
    }
}
