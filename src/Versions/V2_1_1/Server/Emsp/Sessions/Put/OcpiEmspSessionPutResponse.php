<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Put;

use Chargemap\OCPI\Common\Server\OcpiCreateResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session;

class OcpiEmspSessionPutResponse extends OcpiCreateResponse
{
    private Session $session;

    public function __construct(Session $session)
    {
        parent::__construct('Session successfully created.');
        $this->session = $session;
    }

    protected function getData()
    {
        return null;
    }
}
