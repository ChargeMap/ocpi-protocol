<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get;

use Chargemap\OCPI\Common\Server\OcpiListingRequest;
use DateTime;
use Exception;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;

class OcpiEmspTokenGetRequest extends OcpiListingRequest
{
    private ?DateTime $dateFrom;

    private ?DateTime $dateTo;

    /**
     * @param RequestInterface $request
     * @throws Exception
     */
    public function __construct(RequestInterface $request)
    {
        $params = [];
        parse_str($request->getUri()->getQuery(), $params);
        $dateFrom = array_key_exists('date_from', $params) ? new DateTime($params['date_from']) : null;
        $dateTo = array_key_exists('date_to', $params) ? new DateTime($params['date_to']) : null;
        if ($dateFrom !== null && $dateTo !== null && $dateFrom > $dateTo) {
            throw new InvalidArgumentException(sprintf('Date ranges (from %s to %s) are not valid.', $dateFrom->format(DATE_ATOM), $dateTo->format(DATE_ATOM)));
        }

        parent::__construct($request);
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function getDateFrom(): ?DateTime
    {
        return $this->dateFrom;
    }

    public function getDateTo(): ?DateTime
    {
        return $this->dateTo;
    }
}
