<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI;

use Http\Discovery\Psr17FactoryDiscovery;
use JsonSchema\Validator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use stdClass;

class OcpiTestCase extends TestCase
{
    public function createServerRequestInterface(?string $bodySource = null): ServerRequestInterface
    {
        $serverRequestInterface = Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');

        if ($bodySource !== null) {
            $serverRequestInterface = $serverRequestInterface->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents($bodySource)
            ));
        }

        return $serverRequestInterface;
    }

    public static function coerce(string $schemaPath, stdClass $object): void
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