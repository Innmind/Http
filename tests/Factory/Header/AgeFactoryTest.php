<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\AgeFactory,
    Header\Age,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class AgeFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new AgeFactory
        );
    }

    public function testMake()
    {
        $header = (new AgeFactory)(
            Str::of('Age'),
            Str::of('42'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(Age::class, $header);
        $this->assertSame('Age: 42', $header->toString());
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new AgeFactory)(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
