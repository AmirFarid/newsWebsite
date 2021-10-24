<?php

use App\Helper\Api\JsonResponse;


/**
 * @param array $data
 * @param null $mainKey
 * @return JsonResponse
 */
function jResponse(array $data = [], $mainKey = null): JsonResponse
{
    if (is_string($data) && $mainKey == null) {
        $mainKey = $data;
        $data = [];
    }

    return new JsonResponse($data, $mainKey);
}

function stringCorrection($string)
{
    return trim(str_replace(array("\n", "\r", ":"), ' ', $string));
}

function decodeUnicode($string){
    return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
        return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
    }, $string);
}
