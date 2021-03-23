<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules;

use JsonSchema\Validator;
use Psr\Http\Message\ResponseInterface;
use stdClass;
use UnexpectedValueException;

abstract class AbstractResponse
{
    /**
     * @param ResponseInterface $response
     * @param string|null $schemaPath
     * @return mixed
     */
    protected static function toJson(ResponseInterface $response, string $schemaPath = null)
    {
        $jsonObject = json_decode($response->getBody()->__toString(), false, 512, JSON_THROW_ON_ERROR);
        if ($schemaPath !== null) {
            self::validate($jsonObject, $schemaPath);
        }

        return $jsonObject;
    }

    protected static function validate(stdClass $object, string $schemaPath): void
    {
        $validator = new Validator();
        $schemasPath = __DIR__ . '/../../../../resources/jsonSchemas';
        $validator->validate(
            $object,
            (object)['$ref' => 'file://' . realpath($schemasPath) . DIRECTORY_SEPARATOR . $schemaPath]
        );
        if (!$validator->isValid()) {
            throw new UnexpectedValueException('Payload does not validate (' . $validator->getErrors()[0]['pointer'] . ' : ' . $validator->getErrors()[0]['message'] . ')');
        }
    }
}
