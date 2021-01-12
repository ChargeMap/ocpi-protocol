<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiHttpCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiStatusCode;
use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use JsonSerializable;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

abstract class OcpiBaseResponse implements JsonSerializable
{
    protected OcpiHttpCode $ocpiHttpCode;

    protected OcpiStatusCode $ocpiStatusCode;

    protected ?string $statusMessage;

    protected DateTime $timestamp;

    protected function __construct(OcpiHttpCode $ocpiHttpCode, OcpiStatusCode $ocpiStatusCode, string $statusMessage = null)
    {
        $this->ocpiHttpCode = $ocpiHttpCode;
        $this->ocpiStatusCode = $ocpiStatusCode;
        $this->statusMessage = $statusMessage;
        $this->timestamp = new DateTime();
    }

    public function getResponseInterface(ResponseFactoryInterface $responseFactory = null, StreamFactoryInterface $streamFactory = null): ResponseInterface
    {
        if ($responseFactory === null) {
            $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        }

        if ($streamFactory === null) {
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $responseFactory->createResponse($this->ocpiHttpCode->getValue())
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode($this)));
    }

    public function getOcpiHttpCode(): OcpiHttpCode
    {
        return $this->ocpiHttpCode;
    }

    public function getOcpiStatusCode(): OcpiStatusCode
    {
        return $this->ocpiStatusCode;
    }

    public function getStatusMessage(): ?string
    {
        return $this->statusMessage;
    }

    public function getTimestamp(): DateTime
    {
        return $this->timestamp;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'status_code' => $this->ocpiStatusCode,
            'timestamp' => DateTimeFormatter::format($this->timestamp),
        ];

        if (!empty($this->statusMessage)) {
            $return['status_message'] = $this->statusMessage;
        }

        return $return;
    }
}
