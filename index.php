<?php

include 'vendor/autoload.php';

use Stereoflo\CbrCurrency\DailyCurrencies;
use Stereoflo\CbrCurrency\HttpClient\SymfonyHttpClient;
use Stereoflo\CbrCurrency\Parser\XmlParser;

$rate = new DailyCurrencies(new SymfonyHttpClient(), new XmlParser());
$rate->withDate((new DateTime())->modify('-1 year'));
$isOk = $rate->retrieve();

$item = $rate->get('usd');

print $item->getDate()->format('d.m.Y');
