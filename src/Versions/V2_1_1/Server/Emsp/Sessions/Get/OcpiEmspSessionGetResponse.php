<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Get;

use Chargemap\OCPI\Common\Server\OcpiSuccessResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session;

class OcpiEmspSessionGetResponse extends OcpiSuccessResponse
{
    private Session $session;

    public function __construct(Session $session, string $statusMessage = null)
    {
        parent::__construct(OcpiSuccessHttpCode::HTTP_OK(), $statusMessage);
        $this->session = $session;
    }

    protected function getData(): Session
    {
        return $this->session;
    }
}
