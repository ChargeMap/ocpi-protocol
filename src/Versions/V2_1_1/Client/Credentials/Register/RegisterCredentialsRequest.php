<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register;

use Chargemap\OCPI\Common\Client\Modules\Credentials\CredentialsRequest as BaseRequest;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Common\Models\BaseModuleId;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Credentials;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ModuleId;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class RegisterCredentialsRequest extends BaseRequest
{
    private Credentials $credentials;

    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::CRED_AND_REG();
    }

    public function getVersion(): OcpiVersion
    {
        return OcpiVersion::V2_1_1();
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        $request = $serverRequestFactory->createServerRequest('POST', '' );

        if($streamFactory === null ) {
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $request
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withBody($streamFactory->createStream(json_encode($this->credentials->jsonSerialize())));
    }
}