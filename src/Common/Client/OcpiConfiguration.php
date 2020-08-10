<?php

namespace Chargemap\OCPI\Common\Client;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use MongoDB\Driver\Server;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerInterface;

class OcpiConfiguration
{
    protected ?UriInterface $versionEndpoint;

    /** @var OcpiEndpoint[] */
    protected array $endpoints;

    protected string $token;

    protected ClientInterface $httpClient;

    protected ServerRequestFactoryInterface $serverRequestFactory;

    protected StreamFactoryInterface $streamFactory;

    protected ?LoggerInterface $loggerInterface;

    public function __construct(string $token)
    {
        $this->httpClient = Psr18ClientDiscovery::find();
        $this->serverRequestFactory = Psr17FactoryDiscovery::findServerRequestFactory();
        $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $this->token = $token;
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

    public function getEndpoint(OcpiModule $module, OcpiVersion $version): OcpiEndpoint
    {
        foreach ($this->endpoints as $endpoint) {
            if ($module->equals($endpoint->getModule()) && $version->equals($endpoint->getProtocolVersion())) {
                return $endpoint;
            }
        }

        throw new OcpiEndpointNotFoundException(sprintf('Module %s URL not found in version %s', $module->getValue(), $version->getValue()));
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

    public function withEndpoint(OcpiEndpoint $endpoint): self
    {
        // @todo rajouter une vérification du endpoint
        $this->endpoints[] = $endpoint;
        return $this;
    }
}
