<?php

namespace Stereoflo\CbrCurrency\HttpClient;

use Exception;

interface HttpClientInterface
{
    public function execute(string $uri = null): bool;

    public function getRequestError(): ?Exception;

    public function isRequestSuccess(): bool;

    public function getResponseBody(): ?string;

    public function addQuery(string $key, string $value): void;
}
