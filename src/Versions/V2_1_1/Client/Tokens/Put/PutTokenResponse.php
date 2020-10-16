<?php


namespace Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Put;


use Chargemap\OCPI\Common\Client\Modules\Tokens\Put\PutTokenResponse as BaseResponse;
use Psr\Http\Message\ResponseInterface;

class PutTokenResponse extends BaseResponse
{
    private ResponseInterface $responseInterface;

    private function __construct(ResponseInterface $response)
    {
        $this->responseInterface = $response;
    }

    public function getResponseInterface(): ResponseInterface
    {
        return $this->responseInterface;
    }
}