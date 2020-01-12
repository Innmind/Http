<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\ContentTypeFactory,
    Header\ContentType
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class ContentTypeFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new ContentTypeFactory
        );
    }

    public function testMakeWithoutParameters()
    {
        $header = (new ContentTypeFactory)(
            Str::of('Content-Type'),
            Str::of('image/gif'),
        );

        $this->assertInstanceOf(ContentType::class, $header);
        $this->assertSame('Content-Type: image/gif', $header->toString());
    }

    public function testMakeWithParameters()
    {
        $header = (new ContentTypeFactory)(
            Str::of('Content-Type'),
            Str::of('image/gif; foo="bar"; q=0.5'),
        );

        $this->assertInstanceOf(ContentType::class, $header);
        $this->assertSame('Content-Type: image/gif;foo=bar;q=0.5', $header->toString());
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new ContentTypeFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotValid()
    {
        (new ContentTypeFactory)(
            Str::of('Content-Type'),
            Str::of('foo'),
        );
    }
}
