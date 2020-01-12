<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\ContentEncodingFactory,
    Header\ContentEncoding
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class ContentEncodingFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new ContentEncodingFactory
        );
    }

    public function testMake()
    {
        $header = (new ContentEncodingFactory)(
            Str::of('Content-Encoding'),
            Str::of('x-gzip'),
        );

        $this->assertInstanceOf(ContentEncoding::class, $header);
        $this->assertSame('Content-Encoding: x-gzip', $header->toString());
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new ContentEncodingFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }
}
