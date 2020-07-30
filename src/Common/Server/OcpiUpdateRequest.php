<?php

namespace Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Psr\Http\Message\RequestInterface;
use stdClass;

abstract class OcpiUpdateRequest extends OcpiBaseRequest
{
    /** @var stdClass */
    protected $jsonBody;

    protected function __construct(RequestInterface $request)
    {
        if (empty($request->getBody()->__toString())) {
            throw new OcpiNotEnoughInformationClientError('Request body is empty.');
        }
        parent::__construct($request);
        $this->jsonBody = json_decode($request->getBody()->__toString());
    }

    public function getJsonBody(): stdClass
    {
        return $this->jsonBody;
    }
}
