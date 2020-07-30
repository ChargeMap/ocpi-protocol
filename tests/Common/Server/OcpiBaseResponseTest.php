<?php

namespace Tests\Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\OcpiBaseResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessStatusCode;
use DateTime;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class OcpiBaseResponseTest extends TestCase
{
    public function testShouldConstructCorrectly(): void
    {
        /** @var OcpiBaseResponse $mock */
        $mock = $this->getMockBuilder(OcpiBaseResponse::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiBaseResponse::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->setAccessible(true);
        $constructor->invoke($mock, OcpiSuccessHttpCode::HTTP_OK(), OcpiSuccessStatusCode::SUCCESS(), 'Message!');

        $this->assertEquals([
            'status_code' => OcpiSuccessStatusCode::SUCCESS(),
            'timestamp' => (new DateTime())->format(DateTime::ISO8601),
            'status_message' => 'Message!',
        ], $mock->jsonSerialize());
        $responseInterface = $mock->getResponseInterface();

        $this->assertEquals(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());
    }
}
