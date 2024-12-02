<?php

namespace App\Enums;

enum PersonTypes: string
{
    // name = value
    case F = 'Física';
    case J = 'Jurídica';

    /** @return array<string> */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /** @return array<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /** @return array<string, string> */
    public static function array(): array
    {
        return array_combine(self::names(), self::values());
    }

    /** @return array<int, array<string, mixed>> */
    public static function objects(): array
    {
        return array_map(fn (self $state) => ['id' => $state->name, 'name' => $state->value], self::cases());
    }
}
