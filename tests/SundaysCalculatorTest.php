<?php declare(strict_types=1);

use MajaLin\PTest\SundaysCalculator;
use PHPUnit\Framework\TestCase;

final class SundaysCalculatorTest extends TestCase
{
    public function testGetSundaysWithinAYearRange(): void
    {
        $testClass = new SundaysCalculator();

        $this->assertEquals(2, $testClass->getSundays('14-11-1999', '21-11-1999'));
        $this->assertEquals(5, $testClass->getSundays('01-05-2021', '30-05-2021'));
        $this->assertEquals(1, $testClass->getSundays('06-02-2022', '08-02-2022'));
        $this->assertEquals(17, $testClass->getSundays('03-04-2020', '31-07-2020'));
        $this->assertEquals(12, $testClass->getSundays('11-11-1999', '31-01-2000'));
    }

    public function testGetSundaysWithMultipleYearsRange(): void
    {
        $testClass = new SundaysCalculator();

        $this->assertEquals(957, $testClass->getSundays('03-04-2010', '31-07-2028'));
        $this->assertEquals(209, $testClass->getSundays('06-02-2018', '08-02-2022'));
    }

    public function testGetSundaysWithDateInInvalidFormat(): void
    {
        $testClass = new SundaysCalculator();

        $this->expectException(\RuntimeException::class);
        $testClass->getSundays('2021-12-05', '2025-04-01');
    }

    public function testGetSundaysWithInvalidDateRange(): void
    {
        $testClass = new SundaysCalculator();

        $this->expectException(\RuntimeException::class);
        $testClass->getSundays('20-10-2005', '04-03-2005');
    }
}
