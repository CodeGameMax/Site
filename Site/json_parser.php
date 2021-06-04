<?php


class json_parser
{
    public static function get_full_info($filename): array{
        $json = array();
        if (file_exists($filename) && is_readable($filename)) {
            $jfc = file_get_contents($filename);
            $json = json_decode(
                $jfc,
                true,
                512,
                JSON_THROW_ON_ERROR or JSON_UNESCAPED_UNICODE);
        }
        return $json;
    }
}