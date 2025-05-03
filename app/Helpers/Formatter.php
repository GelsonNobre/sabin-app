<?php

namespace App\Helpers;

use DateTime;
use NumberFormatter;

class Formatter
{
    public static function phone(string $value): string
    {
        if (strlen(strval($value)) == 11) {
            $value = preg_replace("/(\d{2})(\d{1})(\d{4})(\d{4})/", "(\$1) \$2 \$3-\$4", $value);
        } else {
            if (strlen(strval($value)) == 10) {
                $value = preg_replace("/(\d{2})(\d{4})(\d{4})/", "(\$1) \$2-\$3", $value);
            }
        }

        return $value;
    }

    public static function cep(string $value): string
    {
        if (strlen(strval($value)) == 8) {
            $value = preg_replace('/([0-9]{2})([0-9]{3})([0-9]{3})/', '$1.$2-$3', $value);
        }

        return $value;
    }

    public static function cpfCnpj(string $value): string
    {
        if (strlen($value) == 14) {
            $value = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $value);
        } else {
            if (strlen($value) == 11) {
                $value = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $value);
            }
        }

        return $value;
    }

    public static function onlyNumbers(string $value): string
    {
        return preg_replace("/[^0-9]/", "", $value);
    }

    public static function double(string $value, ?int $decimals = null): string
    {
        if ($value) {
            $formatter = new NumberFormatter('pt_BR', NumberFormatter::DECIMAL);
            $new_value = $formatter->parse($value);
            $value     = $new_value;

            if ($decimals) {
                $value = number_format($value, $decimals, '.', ',');
            }
        }

        return $value;
    }

    public static function currency(float $value): string
    {
        if ($value) {
            return number_format($value, 2, ',', '.');
        }

        return (string)$value;
    }

    public static function dateUS(string $value): string
    {
        if (strstr($value, '/')) {
            $format = strlen($value) > 10 ? 'd/m/Y H:i:s' : 'd/m/Y';
            $date   = DateTime::createFromFormat($format, $value);

            return $date->format('Y-m-d');
        }

        return $value;
    }

    public static function dateTimeUS(string $value): string
    {
        if (strstr($value, '/')) {
            $format = strlen($value) > 10 ? 'd/m/Y H:i:s' : 'd/m/Y';
            $date   = DateTime::createFromFormat($format, $value);

            return $date->format('Y-m-d H:i:s');
        }

        return $value;
    }

    public static function dateBR(string $value): string
    {
        if ($value) {
            $date = new DateTime($value);

            return $date->format('d/m/Y');
        }

        return $value;
    }

    public static function dateTimeBR(string $value): string
    {
        $date = new DateTime($value);

        return $date->format('d/m/Y H:i:s');
    }

    public static function safeCurrency(mixed $value): string
    {
        if (is_null($value) || $value === '') {
            return 'R$ 0,00';
        }

        // Se vier como string com vírgula, substitui por ponto
        if (is_string($value)) {
            $value = str_replace(',', '.', $value);
        }

        // Garante que é float
        $value = is_numeric($value) ? (float) $value : 0;

        return 'R$ ' . number_format($value, 2, ',', '.');
    }

    public static function toFloat(mixed $value): float
    {
        return (float) str_replace(',', '.', (string) $value);
    }
}
