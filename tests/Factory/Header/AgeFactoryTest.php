<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header\Age,
};
use Innmind\Time\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AgeFactoryTest extends TestCase
{
    public function testMake()
    {
        $header = Factory::new(Clock::live())(
            Str::of('Age'),
            Str::of('42'),
        );

        $this->assertInstanceOf(Age::class, $header);
        $this->assertSame('Age: 42', $header->normalize()->toString());
    }
}
