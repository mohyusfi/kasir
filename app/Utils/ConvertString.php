<?php

namespace App\Utils;

trait ConvertString {
    private function formatToNumber(?string $number): ?float
    {
        if (!is_null($number)) {
            $result = str_replace(",", "", $number);
            return (float)$result;
        }
        return null;
    }
}