<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client;

use Chargemap\OCPI\Common\Models\BaseModuleId;
use Chargemap\OCPI\Common\Models\BaseEndpoint;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerInterface;

class OcpiConfiguration
{
    protected ?UriInterface $versionEndpoint;

    /** @var array<string, array<string, BaseEndpoint>> */
    protected array $endpoints;

    protected string $token;

    protected ClientInterface $httpClient;

    protected ServerRequestFactoryInterface $serverRequestFactory;

    protected StreamFactoryInterface $streamFactory;

    protected ?LoggerInterface $loggerInterface;

    public function __construct(string $token)
    {
        $this->versionEndpoint = null;
        $this->endpoints = [];
        $this->token = $token;
        $this->httpClient = Psr18ClientDiscovery::find();
        $this->serverRequestFactory = Psr17FactoryDiscovery::findServerRequestFactory();
        $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $this->loggerInterface = null;
    }

    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    public function getServerRequestFactory(): ServerRequestFactoryInterface
    {
        return $this->serverRequestFactory;
    }

    public function getStreamFactory(): StreamFactoryInterface
    {
        return $this->streamFactory;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getLogger(): ?LoggerInterface
    {
        return $this->loggerInterface;
    }

    public function getVersionEndpoint(): ?UriInterface
    {
        return $this->versionEndpoint;
    }

    /**
     * @param BaseModuleId $module
     * @param OcpiVersion $version
     * @return BaseEndpoint
     * @throws OcpiEndpointNotFoundException
     */
    public function getEndpoint(BaseModuleId $module, OcpiVersion $version): BaseEndpoint
    {
        if(!array_key_exists($version->getValue(), $this->endpoints) || !array_key_exists($module->getValue(), $this->endpoints[$version->getValue()]) ) {
            throw new OcpiEndpointNotFoundException(sprintf('Module %s URL not found in version %s', $module->getValue(), $version->getValue()));
        }

        return $this->endpoints[$version->getValue()][$module->getValue()];
    }

    public function withHttpClient(ClientInterface $client): self
    {
        $this->httpClient = $client;
        return $this;
    }

    public function withServerRequestFactory(ServerRequestFactoryInterface $serverRequestFactory): self
    {
        $this->serverRequestFactory = $serverRequestFactory;
        return $this;
    }

    public function withStreamFactory(StreamFactoryInterface $streamFactory): self
    {
        $this->streamFactory = $streamFactory;
        return $this;
    }

    public function withLoggerInterface(LoggerInterface $logger): self
    {
        $this->loggerInterface = $logger;
        return $this;
    }

    public function withVersionEndpoint(UriInterface $versionEndpoint): self
    {
        $this->versionEndpoint = $versionEndpoint;
        return $this;
    }

    public function withEndpoint(OcpiVersion $version, BaseEndpoint $endpoint): self
    {
        if(!array_key_exists($version->getValue(), $this->endpoints)) {
            $this->endpoints[$version->getValue()] = [];
        }

        // @todo rajouter une vérification du endpoint
        $this->endpoints[$version->getValue()][$endpoint->getModuleId()->getValue()] = $endpoint;

        return $this;
    }
}
