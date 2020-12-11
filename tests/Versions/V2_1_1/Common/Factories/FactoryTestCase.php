<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use JsonSchema\Validator;
use PHPUnit\Framework\TestCase;
use stdClass;

abstract class FactoryTestCase extends TestCase
{
    public function coerce(string $schemaPath, stdClass $object): void
    {
        $jsonSchemaValidation = new Validator();

        $definition = (object)[
            '$ref' => 'file://' . $schemaPath
        ];

        $jsonSchemaValidation->coerce($object, $definition);

        if (!$jsonSchemaValidation->isValid()) {
            throw new InvalidPayloadException('Payload does not validate ('. $jsonSchemaValidation->getErrors()[0]['pointer'].' : '.$jsonSchemaValidation->getErrors()[0]['message'].')' );
        }
    }
}