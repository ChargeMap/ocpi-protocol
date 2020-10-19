<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Post;

use Chargemap\OCPI\Common\Server\OcpiCreateResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Cdr;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class OcpiEmspCdrPostResponse extends OcpiCreateResponse
{
    private Cdr $cdr;

    private string $cdrUrl;

    public function __construct(Cdr $cdr, string $cdrUrl)
    {
        parent::__construct('Cdr successfully created.');
        $this->cdr = $cdr;
        $this->cdrUrl = $cdrUrl;
    }

    public function getResponseInterface(ResponseFactoryInterface $responseFactory = null, StreamFactoryInterface $streamFactory = null): ResponseInterface
    {
        return parent::getResponseInterface($responseFactory, $streamFactory)
            ->withHeader('Location', $this->cdrUrl);
    }

    protected function getData()
    {
        return null;
    }
}
