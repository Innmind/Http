<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header,
    Header\ContentRange,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentRangeFactoryTest extends TestCase
{
    public function testMakeWithoutLength()
    {
        $header = Factory::new(Clock::live())(
            Str::of('Content-Range'),
            Str::of('bytes 0-42/*'),
        );

        $this->assertInstanceOf(ContentRange::class, $header);
        $this->assertSame('Content-Range: bytes 0-42/*', $header->normalize()->toString());
    }

    public function testMakeWithLength()
    {
        $header = Factory::new(Clock::live())(
            Str::of('Content-Range'),
            Str::of('bytes 0-42/66'),
        );

        $this->assertInstanceOf(ContentRange::class, $header);
        $this->assertSame('Content-Range: bytes 0-42/66', $header->normalize()->toString());
    }

    public function testReturnNothingWhenNotValid()
    {
        $this->assertInstanceOf(
            Header::class,
            Factory::new(Clock::live())(
                Str::of('Content-Range'),
                Str::of('foo'),
            ),
        );
    }
}
