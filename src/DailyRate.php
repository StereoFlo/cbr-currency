<?php

namespace Stereoflo\CbrCurrency;

use DateTime;
use Stereoflo\CbrCurrency\HttpClient\HttpClient;
use Stereoflo\CbrCurrency\HttpClient\HttpClientInterface;
use Stereoflo\CbrCurrency\Parser\ParserInterface;

class DailyRate
{
    protected ?DateTime $date = null;

    protected HttpClientInterface $httpClient;

    protected ParserInterface $parser;

    protected array $data = [];

    public function __construct(HttpClientInterface $httpClient, ParserInterface $parser)
    {
        $this->httpClient = $httpClient;
        $this->parser     = $parser;
        $this->date       = new DateTime();
    }

    public function withDate(DateTime $date): void
    {
        $this->date = $date;
    }

    public function retrieve(): bool
    {
        if ($this->date) {
            $this->httpClient->addQuery('date_req', $this->date->format('d/m/Y'));
        }

        $this->httpClient->execute(HttpClient::URI_XML_DAILY);
        if (!$this->httpClient->isRequestSuccess()) {

            return false;
        }

        $xml    = $this->httpClient->getResponseBody();
        $parser = $this->parser;

        if ($this->data = $parser->parse($xml)) {

            return true;
        }

        return false;
    }

    public function get(string $charCode): ?DailyRateItem
    {
        $charCode = strtoupper($charCode);

        if (!isset($this->data[$charCode])) {
            return null;
        }

        return $this->data[$charCode];
    }
}
