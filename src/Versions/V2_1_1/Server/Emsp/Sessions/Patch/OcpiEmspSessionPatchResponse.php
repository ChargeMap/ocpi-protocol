<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Patch;

use Chargemap\OCPI\Common\Server\OcpiUpdateResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialSession;

class OcpiEmspSessionPatchResponse extends OcpiUpdateResponse
{
    private PartialSession $session;

    public function __construct(PartialSession $session)
    {
        parent::__construct('Session successfully updated');
        $this->session = $session;
    }

    protected function getData()
    {
        return null;
    }
}
