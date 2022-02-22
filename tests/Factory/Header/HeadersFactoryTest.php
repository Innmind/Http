<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\HeadersFactory,
    Factory\HeaderFactory,
    Factory\HeadersFactory as HeadersFactoryInterface,
    Headers
};
use Innmind\Immutable\{
    Maybe,
    Str,
};
use PHPUnit\Framework\TestCase;

class HeadersFactoryTest extends TestCase
{
    public function testMake()
    {
        $_SERVER['HTTP_AUTHORIZATION'] = 'Basic foo';
        $_SERVER['CONTENT_LENGTH'] = '0';
        $_SERVER['CONTENT_MD5'] = '0';
        $_SERVER['CONTENT_TYPE'] = 'text/plain';

        $f = HeadersFactory::default(
            new class implements HeaderFactory {
                public function __invoke(Str $name, Str $value): Maybe
                {
                    return Maybe::nothing();
                }
            },
        );

        $this->assertInstanceOf(HeadersFactoryInterface::class, $f);
        $this->assertInstanceOf(Headers::class, ($f)());
        $this->assertTrue(($f)()->contains('authorization'));
        $this->assertTrue(($f)()->contains('content-length'));
        $this->assertTrue(($f)()->contains('content-md5'));
        $this->assertTrue(($f)()->contains('content-type'));
    }
}
