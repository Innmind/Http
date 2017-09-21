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
        $header = (new ContentTypeFactory)->make(
            new Str('Content-Type'),
            new Str('image/gif')
        );

        $this->assertInstanceOf(ContentType::class, $header);
        $this->assertSame('Content-Type : image/gif', (string) $header);
    }

    public function testMakeWithParameters()
    {
        $header = (new ContentTypeFactory)->make(
            new Str('Content-Type'),
            new Str('image/gif; foo="bar"; q=0.5')
        );

        $this->assertInstanceOf(ContentType::class, $header);
        $this->assertSame('Content-Type : image/gif;foo=bar;q=0.5', (string) $header);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new ContentTypeFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotValid()
    {
        (new ContentTypeFactory)->make(
            new Str('Content-Type'),
            new Str('foo')
        );
    }
}
