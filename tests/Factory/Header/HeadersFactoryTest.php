<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\HeadersFactory,
    Factory\HeaderFactory,
    Factory\HeadersFactory as HeadersFactoryInterface,
    Headers
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class HeadersFactoryTest extends TestCase
{
    public function testMake()
    {
        $_SERVER['HTTP_AUTHORIZATION'] = 'Basic foo';
        $_SERVER['CONTENT_LENGTH'] = '0';
        $_SERVER['CONTENT_MD5'] = '0';
        $_SERVER['CONTENT_TYPE'] = 'text/plain';

        $f = new HeadersFactory(
            $this->createMock(HeaderFactory::class)
        );

        $this->assertInstanceOf(HeadersFactoryInterface::class, $f);
        $this->assertInstanceOf(Headers::class, $f->make());
        $this->assertTrue($f->make()->contains('authorization'));
        $this->assertTrue($f->make()->contains('content-length'));
        $this->assertTrue($f->make()->contains('content-md5'));
        $this->assertTrue($f->make()->contains('content-type'));
    }
}
