<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\ContentLengthFactory,
    Header\ContentLength,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class ContentLengthFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new ContentLengthFactory
        );
    }

    public function testMake()
    {
        $header = (new ContentLengthFactory)(
            Str::of('Content-Length'),
            Str::of('42'),
        );

        $this->assertInstanceOf(ContentLength::class, $header);
        $this->assertSame('Content-Length: 42', $header->toString());
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new ContentLengthFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }
}
