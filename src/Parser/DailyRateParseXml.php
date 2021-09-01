<?php

namespace Stereoflo\CbrCurrency\Parser;

use DateTime;
use SimpleXMLElement;
use Stereoflo\CbrCurrency\DailyRateItem;

class DailyRateParseXml implements ParserInterface
{
    public function parse(string $xml): array
    {
        $data = [];
        $simple = simplexml_load_string($xml);
        $date = DateTime::createFromFormat('d.m.Y', (string) $simple->attributes()->Date);

        foreach ($simple->Valute as $row) {
            $item = new DailyRateItem($date, $row);
            $data[$item->getCharCode()] = $item;
        }

        return $data;
    }
}
