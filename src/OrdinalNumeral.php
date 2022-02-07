<?php

namespace MajaLin\PTest;

use RuntimeException;

class OrdinalNumeral implements SimpleFunction
{
    public const KNOWN_INDICATOR_SUFFIX = [
        1 => 'st',
        2 => 'nd',
        3 => 'rd',
    ];

    public const EXCEPTION_NUMBER = [
        11,
        12,
        13,
    ];

    public static function execute(): mixed
    {
        return (new self)->getOrdinalNumber(...func_get_args());
    }

    public function getOrdinalNumber(int $input): string
    {
        if ($input <= 0) {
            throw new RuntimeException("Cannot find the ordinal numeral!");
        }

        # Check if the given integer follows the suffix rule
        $baseNumeral = $input % 100;
        if (!in_array($baseNumeral, self::EXCEPTION_NUMBER)) {
            $baseNumeral = $input % 10;

            if (in_array($baseNumeral, array_keys(self::KNOWN_INDICATOR_SUFFIX))) {
                return sprintf('%s%s', $input, self::KNOWN_INDICATOR_SUFFIX[$baseNumeral]);
            }
        }

        return sprintf('%s%s', $input, 'th');
    }
}
