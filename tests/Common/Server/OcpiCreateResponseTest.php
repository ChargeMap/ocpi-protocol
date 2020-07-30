<?php

namespace Tests\Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\OcpiBaseResponse;
use Chargemap\OCPI\Common\Server\OcpiCreateResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class OcpiCreateResponseTest extends TestCase
{
    public function testShouldConstructCorrectly()
    {
        $mock = $this->getMockBuilder(OcpiCreateResponse::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiCreateResponse::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock, 'Message!');
        $mock->method('getData')->willReturn(null);

        /** @var OcpiBaseResponse $mock */
        $this->assertEquals('Message!', $mock->jsonSerialize()['status_message']);
        $responseInterface = $mock->getResponseInterface();

        $this->assertEquals(OcpiSuccessHttpCode::HTTP_CREATED, $responseInterface->getStatusCode());
    }
}
