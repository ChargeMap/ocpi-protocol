<?php


namespace Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch;

use Chargemap\OCPI\Common\Client\Modules\Tokens\Patch\PatchTokenResponse as BaseResponse;
use Psr\Http\Message\ResponseInterface;

class PatchTokenResponse extends BaseResponse
{
    private ResponseInterface $responseInterface;

    public function __construct(ResponseInterface $response)
    {
        $this->responseInterface = $response;
    }

    public function getResponseInterface(): ResponseInterface
    {
        return $this->responseInterface;
    }
}