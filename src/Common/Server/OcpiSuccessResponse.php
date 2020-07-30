<?php

namespace Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessStatusCode;
use InvalidArgumentException;
use JsonSerializable;

abstract class OcpiSuccessResponse extends OcpiBaseResponse implements JsonSerializable
{
    public function __construct(OcpiSuccessHttpCode $ocpiHttpCode, string $statusMessage = null)
    {
        parent::__construct($ocpiHttpCode, OcpiSuccessStatusCode::SUCCESS(), $statusMessage);
    }

    public function jsonSerialize(): array
    {
        $return = parent::jsonSerialize();
        $data = static::getData();
        if (!is_null($data) && !is_array($data) && !is_object($data) && !is_string($data)) {
            throw new InvalidArgumentException('Data must be a string, an array, an object or null');
        }
        $return['data'] = $data;

        return $return;
    }

    /**
     * @return array|object|string|null
     */
    abstract protected function getData();
}
