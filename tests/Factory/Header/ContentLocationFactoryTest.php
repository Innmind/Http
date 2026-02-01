<?php
declare(strict_types = 1);

namespace Test\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header\ContentLocation,
};
use Innmind\Time\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentLocationFactoryTest extends TestCase
{
    public function testMake()
    {
        $header = Factory::new(Clock::live())(
            Str::of('Content-Location'),
            Str::of('http://example.com'),
        );

        $this->assertInstanceOf(ContentLocation::class, $header);
        $this->assertSame('Content-Location: http://example.com/', $header->normalize()->toString());
    }
}
