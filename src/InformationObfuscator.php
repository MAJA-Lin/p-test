<?php

namespace MajaLin\PTest;

use RuntimeException;

class InformationObfuscator implements SimpleFunction
{
    public function execute(): mixed
    {
        return $this->obfuscateInformation(...func_get_args());
    }

    public function obfuscateInformation(string $input)
    {
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return $this->obfuscateEmail($input);
        }

        if (preg_match('/^(\+|[0-9])([0-9 ]+)$/', $input) === 1) {
            return $this->obfuscatePhoneNumber($input);
        }

        throw new RuntimeException("This obfuscation method only supports email and phone number.");
    }

    protected function obfuscateEmail(string $input): string
    {
        preg_match('/^([^@]+)(\@.*)$/', $input, $emailParts);
        $localPart = $emailParts[1];
        $lengthForAsterisks = mb_strlen($localPart) - 2;

        $obfuscatedParts = substr_replace(
            $localPart,
            $this->getAsterisksString($lengthForAsterisks),
            1,
            $lengthForAsterisks
        );

        return sprintf('%s%s', $obfuscatedParts, $emailParts[2]);
    }

    protected function obfuscatePhoneNumber(string $input): string
    {
        $digits = str_replace(' ', '', (str_replace('+', '', $input)));
        if (mb_strlen($digits) < 9) {
            throw new RuntimeException("Phone number should contain at least 9 digits.");
        }

        $splittedNumbers = explode('-', (str_replace(' ', '-', $input)));
        $quotaNotToObfuscate = 4;

        for ($i = count($splittedNumbers) - 1; $i >= 0; $i--) {
            $lengthOfCurrentNumbers = mb_strlen($splittedNumbers[$i]);
            $indexToReplace = 0;

            if ($quotaNotToObfuscate >= $lengthOfCurrentNumbers) {
                $quotaNotToObfuscate -= $lengthOfCurrentNumbers;
                continue;
            }

            $digitsToObfuscate = $lengthOfCurrentNumbers - $quotaNotToObfuscate;
            // Ignore plus sign
            if ((strpos($splittedNumbers[$i], '+') !== false)) {
                $digitsToObfuscate -= 1;
                $indexToReplace = 1;
            }

            $splittedNumbers[$i] = substr_replace(
                $splittedNumbers[$i],
                $this->getAsterisksString($digitsToObfuscate),
                $indexToReplace,
                $digitsToObfuscate
            );

            // Reset revealing quota
            $quotaNotToObfuscate = 0;
        }

        return implode('-', $splittedNumbers);
    }

    private function getAsterisksString(int $length): string
    {
        return str_repeat('*', $length);
    }
}
