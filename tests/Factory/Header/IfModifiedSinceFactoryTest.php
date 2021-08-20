<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\IfModifiedSinceFactory,
    Factory\HeaderFactory,
    Header\IfModifiedSince,
};
use Innmind\TimeContinuum\Earth\Clock;
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class IfModifiedSinceFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new IfModifiedSinceFactory(new Clock);

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('If-Modified-Since'),
            Str::of('Tue, 15 Nov 1994 08:12:31 GMT'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(IfModifiedSince::class, $h);
        $this->assertSame(
            'If-Modified-Since: Tue, 15 Nov 1994 08:12:31 GMT',
            $h->toString(),
        );
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new IfModifiedSinceFactory(new Clock))(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenNotOfExpectedFormat()
    {
        $this->assertNull((new IfModifiedSinceFactory(new Clock))(
            Str::of('If-Modified-Since'),
            Str::of('2020-01-01'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
