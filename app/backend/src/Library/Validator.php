<?php

namespace Nathan\Kabum\Library;

use DateTime;

class Validator
{
    public static function validateStr(mixed $str, int $minLen = 1, int $maxLen = -1): bool
    {
        if (empty($str)) {
            return false;
        }

        $len = strlen($str);

        if ($len < $minLen) {
            return false;
        }

        if ($maxLen > 0 && $len > $maxLen) {
            return false;
        }

        return true;
    }

    // Ref: https://www.php.net/manual/pt_BR/function.checkdate.php#113205
    public static function validateDate(mixed $date, string $format = 'Y-m-d'): bool
    {
        if (empty($date)) {
            return false;
        }

        $datetime = DateTime::createFromFormat($format, $date);

        return $datetime && $datetime->format($format) == $date;
    }

    // Ref: https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40
    public static function validateCPF(?string $cpf): bool
    {

        if (empty($cpf)) {
            return false;
        }

        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {

            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    public static function validatePhone($phone): bool
    {
        if (empty($phone)) {
            return false;
        }

        $phone = preg_replace('/[^0-9]/is', '', $phone);

        return preg_match('/^\(?\d{2}\)?\s?\d{4,5}\-?\d{4}$/', $phone);
    }
}
