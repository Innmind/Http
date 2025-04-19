<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header,
    Header\Link,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class LinkFactoryTest extends TestCase
{
    public function testMake()
    {
        $header = Factory::new(Clock::live())(
            Str::of('Link'),
            Str::of('</foo>; rel="next"; title=foo; bar="baz", </bar>'),
        );

        $this->assertInstanceOf(Link::class, $header);
        $this->assertSame(
            'Link: </foo>; rel="next";title=foo;bar=baz, </bar>; rel="related"',
            $header->toHeader()->toString(),
        );
    }

    public function testMakeWithComplexParameterValue()
    {
        $header = Factory::new(Clock::live())(
            Str::of('Link'),
            Str::of('</foo>; rel="next"; title="!#$%&\'()*+-./0123456789:<=>?@abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVWXYZ[]^_`{|}~"'),
        );

        $this->assertInstanceOf(Link::class, $header);
        $this->assertSame(
            'Link: </foo>; rel="next";title=!#$%&\'()*+-./0123456789:<=>?@abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVWXYZ[]^_`{|}~',
            $header->toHeader()->toString(),
        );
    }

    public function testReturnNothingWhenNotValid()
    {
        $this->assertInstanceOf(
            Header::class,
            Factory::new(Clock::live())(
                Str::of('Link'),
                Str::of('foo'),
            ),
        );
    }
}
