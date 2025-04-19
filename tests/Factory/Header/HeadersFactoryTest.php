<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeadersFactory,
    Headers,
};
use Innmind\TimeContinuum\Clock;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class HeadersFactoryTest extends TestCase
{
    public function testMake()
    {
        $_SERVER['HTTP_AUTHORIZATION'] = 'Basic foo';
        $_SERVER['CONTENT_LENGTH'] = '0';
        $_SERVER['CONTENT_MD5'] = '0';
        $_SERVER['CONTENT_TYPE'] = 'text/plain';

        $f = HeadersFactory::native(Clock::live());

        $this->assertInstanceOf(Headers::class, ($f)());
        $this->assertTrue(($f)()->contains('authorization'));
        $this->assertTrue(($f)()->contains('content-length'));
        $this->assertTrue(($f)()->contains('content-md5'));
        $this->assertTrue(($f)()->contains('content-type'));
    }
}
