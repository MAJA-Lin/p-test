<?php declare(strict_types=1);

use MajaLin\PTest\OrdinalNumeral;
use PHPUnit\Framework\TestCase;

final class StackTest extends TestCase
{
    public function testGetOrdinalNumberWithNormalInput(): void
    {
        $testClass = new OrdinalNumeral();

        $this->assertEquals('11th', $testClass->getOrdinalNumber(11));
        $this->assertEquals('2050th', $testClass->getOrdinalNumber(2050));
        $this->assertEquals('3rd', $testClass->getOrdinalNumber(3));
        $this->assertEquals('10052nd', $testClass->getOrdinalNumber(10052));
        $this->assertEquals('99001st', $testClass->getOrdinalNumber(99001));
    }

    public function testGetOrdinalNumberWithInputZero(): void
    {
        $testClass = new OrdinalNumeral();
        $this->expectException(\RuntimeException::class);
        $testClass->getOrdinalNumber(0);
    }

    public function testGetOrdinalNumberWithNegativeInput(): void
    {
        $testClass = new OrdinalNumeral();
        $this->expectException(\RuntimeException::class);
        $testClass->getOrdinalNumber(-1503);
    }

    public function testGetOrdinalNumberWithStringInput(): void
    {
        $testClass = new OrdinalNumeral();
        $this->expectException(\TypeError::class);
        $testClass->getOrdinalNumber('String input');
    }
}
