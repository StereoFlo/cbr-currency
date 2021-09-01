<?php

namespace Stereoflo\CbrCurrency\HttpClient;

use Exception;

class HttpClient implements HttpClientInterface
{
    const URI_XML_DAILY = 'https://www.cbr.ru/scripts/XML_daily.asp';

    private array $query = [];
    private ?Exception $requestError;
    private ?string $responseBody;
    private bool $isRequestSuccess = false;

    public function execute(string $uri = null): bool
    {
        if (!$uri) {
            $uri = self::URI_XML_DAILY;
        }

        try {
            $this->makeRequest($uri);
            $this->isRequestSuccess = true;

            return true;
        } catch (Exception $e) {
            $this->isRequestSuccess = false;
            $this->requestError = $e;
        }

        return false;
    }

    public function getRequestError(): ?Exception
    {
        return $this->requestError;
    }

    public function isRequestSuccess(): bool
    {
        return $this->isRequestSuccess;
    }

    public function getResponseBody(): ?string
    {
        return $this->responseBody;
    }

    public function addQuery(string $key, string $value): void
    {
        $this->query[$key] = $value;
    }

    private function makeRequest(string $uri): void
    {
        $client = \Symfony\Component\HttpClient\HttpClient::create();
        $res = $client->request('GET', $this->buildUri($uri));
        $this->isRequestSuccess = true;
        $this->responseBody = $res->getContent();
    }

    private function buildUri(string $uri): string
    {
        $path = $uri;

        if ($this->query) {
            $path .= '?' . http_build_query($this->query);
        }

        return $path;
    }
}
