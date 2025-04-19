<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header\ContentLength,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentLengthFactoryTest extends TestCase
{
    public function testMake()
    {
        $header = Factory::new(Clock::live())(
            Str::of('Content-Length'),
            Str::of('42'),
        );

        $this->assertInstanceOf(ContentLength::class, $header);
        $this->assertSame('Content-Length: 42', $header->toString());
    }
}
