<?php

namespace Tests\Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\OcpiBaseResponse;
use Chargemap\OCPI\Common\Server\OcpiUpdateResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class OcpiUpdateResponseTest extends TestCase
{
    public function testShouldConstructCorrectly()
    {
        $mock = $this->getMockBuilder(OcpiUpdateResponse::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiUpdateResponse::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock, 'Message!');
        $mock->method('getData')->willReturn(null);

        /** @var OcpiBaseResponse $mock */
        $this->assertEquals('Message!', $mock->jsonSerialize()['status_message']);
        $responseInterface = $mock->getResponseInterface();

        $this->assertEquals(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());
    }
}
