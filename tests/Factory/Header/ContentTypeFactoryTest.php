<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Factory\Header\ContentTypeFactory,
    Header\ContentType
};
use Innmind\Immutable\StringPrimitive as Str;

class ContentTypeFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
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
}
