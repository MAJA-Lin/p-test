<?php

namespace MajaLin\PTest;

use RuntimeException;

class OrdinalNumeral
{
    public const KNOWN_INDICATOR_SUFFIX = [
        1 => 'st',
        2 => 'nd',
        3 => 'rd',
        11 => 'th',
        12 => 'th',
        13 => 'th',
    ];

    public function getOrdinalNumber(int $input): string
    {
        if ($input <= 0) {
            throw new RuntimeException("Cannot find the ordinal numeral!");
        }

        $baseNumeral = $input % 100;

        if (in_array($baseNumeral, array_keys(self::KNOWN_INDICATOR_SUFFIX))) {
            return sprintf('%s%s', $input, self::KNOWN_INDICATOR_SUFFIX[$baseNumeral]);
        }

        $baseNumeral = $input % 10;
        if (in_array($baseNumeral, array_keys(self::KNOWN_INDICATOR_SUFFIX))) {
            return sprintf('%s%s', $input, self::KNOWN_INDICATOR_SUFFIX[$baseNumeral]);
        }

        return sprintf('%s%s', $input, 'th');
    }
}
