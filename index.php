<?php

include 'vendor/autoload.php';

use Stereoflo\CbrCurrency\DailyRate;
use Stereoflo\CbrCurrency\HttpClient\HttpClient;
use Stereoflo\CbrCurrency\Parser\DailyRateParseXml;

$rate = new DailyRate(new HttpClient(), new DailyRateParseXml());
$rate->withDate((new DateTime())->modify('-1 year'));
$isOk = $rate->retrieve();

$item = $rate->get('usd');

print $item->getDate()->format('d.m.Y');
