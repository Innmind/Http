<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\LinkFactory,
    Header\Link,
};
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class LinkFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new LinkFactory,
        );
    }

    public function testMake()
    {
        $header = (new LinkFactory)(
            Str::of('Link'),
            Str::of('</foo>; rel="next"; title=foo; bar="baz", </bar>'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
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
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(Link::class, $header);
        $this->assertSame(
            'Link: </foo>; rel="next";title=!#$%&\'()*+-./0123456789:<=>?@abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVWXYZ[]^_`{|}~',
            $header->toString(),
        );
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new LinkFactory)(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenNotValid()
    {
        $this->assertNull((new LinkFactory)(
            Str::of('Link'),
            Str::of('foo'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
