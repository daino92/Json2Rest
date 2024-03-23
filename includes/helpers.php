<?php  namespace Json2Rest\Helpers;

function decode_unicode_sequences($json_string) {
    return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function($match) {
        return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
    }, $json_string);
}