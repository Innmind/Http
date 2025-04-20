<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header,
    Header\ContentType,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentTypeFactoryTest extends TestCase
{
    public function testMakeWithoutParameters()
    {
        $header = Factory::new(Clock::live())(
            Str::of('Content-Type'),
            Str::of('image/gif'),
        );

        $this->assertInstanceOf(ContentType::class, $header);
        $this->assertSame('Content-Type: image/gif', $header->normalize()->toString());
    }

    public function testMakeWithParameters()
    {
        $header = Factory::new(Clock::live())(
            Str::of('Content-Type'),
            Str::of('image/gif; foo="bar"; q=0.5'),
        );

        $this->assertInstanceOf(ContentType::class, $header);
        $this->assertSame('Content-Type: image/gif;foo=bar;q=0.5', $header->normalize()->toString());
    }

    public function testReturnNothingWhenNotValid()
    {
        $this->assertInstanceOf(
            Header::class,
            Factory::new(Clock::live())(
                Str::of('Content-Type'),
                Str::of('foo'),
            ),
        );
    }

    public function testFormEncoded()
    {
        $header = Factory::new(Clock::live())(
            Str::of('Content-Type'),
            Str::of('application/x-www-form-urlencoded'),
        );

        $this->assertInstanceOf(ContentType::class, $header);
        $this->assertSame(
            'Content-Type: application/x-www-form-urlencoded',
            $header->normalize()->toString(),
        );
    }
}
