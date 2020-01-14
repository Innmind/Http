<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\LinkFactory,
    Header\Link,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class LinkFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new LinkFactory
        );
    }

    public function testMake()
    {
        $header = (new LinkFactory)(
            Str::of('Link'),
            Str::of('</foo>; rel="next"; title=foo; bar="baz", </bar>'),
        );

        $this->assertInstanceOf(Link::class, $header);
        $this->assertSame(
            'Link: </foo>; rel="next";title=foo;bar=baz, </bar>; rel="related"',
            $header->toString(),
        );
    }

    public function testMakeWithComplexParameterValue()
    {
        $header = (new LinkFactory)(
            Str::of('Link'),
            Str::of('</foo>; rel="next"; title="!#$%&\'()*+-./0123456789:<=>?@abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVWXYZ[]^_`{|}~"'),
        );

        $this->assertInstanceOf(Link::class, $header);
        $this->assertSame(
            'Link: </foo>; rel="next";title=!#$%&\'()*+-./0123456789:<=>?@abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVWXYZ[]^_`{|}~',
            $header->toString(),
        );
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new LinkFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }

    public function testThrowWhenNotValid()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new LinkFactory)(
            Str::of('Link'),
            Str::of('foo'),
        );
    }
}
