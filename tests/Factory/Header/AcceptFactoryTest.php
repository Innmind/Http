<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptFactory,
    Factory\HeaderFactory,
    Header\Accept,
};
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AcceptFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new AcceptFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('Accept'),
            Str::of('audio/*; q=0.2; level="1", audio/basic'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(Accept::class, $h);
        $this->assertSame('Accept: audio/*;q=0.2;level=1, audio/basic', $h->toString());
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new AcceptFactory)(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenNotValid()
    {
        $this->assertNull((new AcceptFactory)(
            Str::of('Accept'),
            Str::of('@'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
