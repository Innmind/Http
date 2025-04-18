<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\IfUnmodifiedSinceFactory,
    Factory\HeaderFactory,
    Header\IfUnmodifiedSince,
};
use Innmind\TimeContinuum\Earth\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class IfUnmodifiedSinceFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new IfUnmodifiedSinceFactory(new Clock);

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('If-Unmodified-Since'),
            Str::of('Tue, 15 Nov 1994 08:12:31 GMT'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(IfUnmodifiedSince::class, $h);
        $this->assertSame(
            'If-Unmodified-Since: Tue, 15 Nov 1994 08:12:31 GMT',
            $h->toString(),
        );
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new IfUnmodifiedSinceFactory(new Clock))(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenNotOfExpectedFormat()
    {
        $this->assertNull((new IfUnmodifiedSinceFactory(new Clock))(
            Str::of('If-Unmodified-Since'),
            Str::of('2020-01-01'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
