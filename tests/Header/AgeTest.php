<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Age,
    Header,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AgeTest extends TestCase
{
    public function testOf()
    {
        $header = Age::of(42);

        $this->assertInstanceOf(Age::class, $header);
        $this->assertInstanceOf(Header\Custom::class, $header);
        $this->assertSame('Age: 42', $header->normalize()->toString());
    }

    public function testReturnNothingWhenInvalidAgeValue()
    {
        $this->assertNull(Age::maybe(-1)->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
