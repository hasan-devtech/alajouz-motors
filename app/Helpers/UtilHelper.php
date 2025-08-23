<?php

const PAGINATION = [10, 25, 50, 100];
const ALAJOUZ_LATITUDE = 33.532436;
const ALAJOUZ_LONGITUDE = 36.228012;

function enumValues(string $enum)
{
    return array_column($enum::cases(), 'value');
}

function enumKeys(string $enum)
{
    return array_column($enum::cases(), 'key');
}

function slugAr($string = null, $separator = "-")
{
    if ($string === null)
        return "";

    $string = trim($string);
    $string = mb_strtolower($string, "UTF-8");
    $string = preg_replace("/[^\p{L}0-9_\s-]/u", "", $string);
    $string = preg_replace("/[\s-]+/", " ", $string);
    $string = preg_replace("/[\s_]/", $separator, $string);

    return $string;
}

