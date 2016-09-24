<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Factory\Header\ContentLengthFactory,
    Header\ContentLength
};
use Innmind\Immutable\StringPrimitive as Str;

class ContentLengthFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
            new ContentLengthFactory
        );
    }

    public function testMake()
    {
        $header = (new ContentLengthFactory)->make(
            new Str('Content-Length'),
            new Str('42')
        );

        $this->assertInstanceOf(ContentLength::class, $header);
        $this->assertSame('Content-Length : 42', (string) $header);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new ContentLengthFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}
