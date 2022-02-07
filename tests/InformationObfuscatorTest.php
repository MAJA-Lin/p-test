<?php declare(strict_types=1);

use MajaLin\PTest\InformationObfuscator;
use PHPUnit\Framework\TestCase;

final class InformationObfuscatorTest extends TestCase
{
    public function testEmailObfuscation(): void
    {
        $testClass = new InformationObfuscator();

        $this->assertEquals(
            't*************n@obfuscate.notedu.org',
            $testClass->obfuscateInformation('testObfuscation@obfuscate.notedu.org')
        );

        $this->assertEquals(
            'j***************d@test.com',
            $testClass->obfuscateInformation('ja123.hello.world@test.com')
        );

        $this->assertEquals(
            'qq@email.test',
            $testClass->obfuscateInformation('qq@email.test')
        );
    }

    public function testPhoneNumberObfuscation()
    {
        $testClass = new InformationObfuscator();

        $this->assertEquals(
            '+**-**-*7-660',
            $testClass->obfuscateInformation('+23 55 17 660')
        );

        $this->assertEquals(
            '***-****-***-**2-550',
            $testClass->obfuscateInformation('123 0923 442 112 550')
        );

        $this->assertEquals(
            '***-****-***-***-***-*********************-****-*****-*****-****-1234',
            $testClass->obfuscateInformation('123 0923 442 112 550 119955557656746536555 4230 77102 02456 3546 1234')
        );
    }

    public function testObfuscationWithInvalidFormatInput()
    {
        $testClass = new InformationObfuscator();

        $this->expectException(\RuntimeException::class);
        $testClass->obfuscateInformation('Random string input');
    }

    public function testObfuscationWithInvalidFormatPhoneNumberInput()
    {
        $testClass = new InformationObfuscator();

        $this->expectException(\RuntimeException::class);
        $testClass->obfuscateInformation('(+890 55 443');
    }


    public function testPhoneNumberObfuscationWithLessThanNineDigits()
    {
        $testClass = new InformationObfuscator();

        $this->expectException(\RuntimeException::class);

        $testClass->obfuscateInformation('+23 55 7 66');
    }
}
