<?php

require './src/bootstrap.php';

use MajaLin\PTest\InformationObfuscator;
use MajaLin\PTest\OrdinalNumeral;
use MajaLin\PTest\SundaysCalculator;

if (count($argv) < 2) {
    print_r("Please enter input.\n");
    exit;
}

$classMapping = [
    'ordinal' => OrdinalNumeral::class,
    'obfuscate' => InformationObfuscator::class,
    'sunday' => SundaysCalculator::class,
];

if (!array_key_exists($argv[1], $classMapping)) {
    throw new \RuntimeException("Please enter operation.\n");
}

$arguments = $argv;
unset($arguments[0]);
unset($arguments[1]);

printf("%s\n", $classMapping[$argv[1]]::execute(...$arguments));
