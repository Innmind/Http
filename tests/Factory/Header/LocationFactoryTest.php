<?php
declare(strict_types = 1);

namespace Test\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\LocationFactory,
    Header\Location,
};
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class LocationFactoryTest extends TestCase
{
    public function testMake()
    {
        $header = (new LocationFactory)(
            Str::of('Location'),
            Str::of('http://example.com'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(Location::class, $header);
        $this->assertSame('Location: http://example.com/', $header->toString());
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new LocationFactory)(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
