<?php

namespace App\Helpers;

class XmlHandler
{

    public static function convertToArray(string $content, string $key = ''): array
    {

        $xml = simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);
        return !empty($key) ? $array[$key] : $array;
    }

}
