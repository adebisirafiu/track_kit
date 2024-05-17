<?php
namespace App;

class JsonValidator {
    public static function validateAndConvert($jsonString) {
        $array = is_string($jsonString) ? json_decode($jsonString, true) : $jsonString;

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON: ' . json_last_error_msg());
        }

        if (!isset($array['data'])) {
            throw new \InvalidArgumentException('Missing "data" key in JSON data');
        }

        return $array;
    }
}
