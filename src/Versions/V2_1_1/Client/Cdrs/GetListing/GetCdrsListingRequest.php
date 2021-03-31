<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing;

use Chargemap\OCPI\Common\Client\Modules\ListingRequest;
use Chargemap\OCPI\Common\Client\Modules\Cdrs\GetListing\GetCdrsListingRequest as BaseRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ModuleId;
use DateTime;
use DateTimeInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class GetCdrsListingRequest extends BaseRequest
{
    use VersionTrait;
    use ListingRequest;

    private ?DateTime $dateFrom;

    private ?DateTime $dateTo;

    public static function builder(): self
    {
        return new self();
    }

    public function withDateFrom(DateTime $dateFrom): self
    {
        $this->dateFrom = $dateFrom;
        return $this;
    }

    public function withDateTo(DateTime $dateTo): self
    {
        $this->dateTo = $dateTo;
        return $this;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::CDRS();
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        return $serverRequestFactory->createServerRequest('GET', '?' . $this->getQueryString());
    }

    private function getQueryString(): string
    {
        $parameters = [];

        if (!empty($this->limit)) {
            $parameters['limit'] = $this->limit;
        }

        if (!empty($this->offset)) {
            $parameters['offset'] = $this->offset;
        }

        if (!empty($this->dateFrom)) {
            $parameters['date_from'] = $this->dateFrom->format(DateTimeInterface::RFC3339);
        }

        if (!empty($this->dateTo)) {
            $parameters['date_to'] = $this->dateTo->format(DateTimeInterface::RFC3339);
        }

        return http_build_query($parameters);
    }
}