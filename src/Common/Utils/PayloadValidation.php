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
        $jsonSchemaValidation = self::validator($schemaPath,$object);
        if (!$jsonSchemaValidation->isValid()) {
            $errors = [];
            foreach ($jsonSchemaValidation->getErrors() as $error) {
                $errors[] = "property: " . $error['property'] . ', error: ' . $error['message'] . '. ';
            }
            throw new OcpiInvalidPayloadClientError(sprintf('Payload does not validate %s. Issues: %s',
                basename($schemaPath), implode($errors)));
        }
    }

    public static function isValidJson(string $schemaPath,stdClass $json): bool
    {
        $jsonSchemaValidation = self::validator($schemaPath,$json);
        return $jsonSchemaValidation->isValid();
    }

    private static function validator(string $schemaPath, stdClass $json): Validator
    {
        $jsonSchemaValidation = new Validator();
        $schemasPath = __DIR__ . '/../../../resources/jsonSchemas/';
        $jsonSchemaValidation->coerce(
            $json,
            (object)['$ref' => 'file://' . realpath($schemasPath) . DIRECTORY_SEPARATOR . $schemaPath]
        );
        return $jsonSchemaValidation;
    }
}
