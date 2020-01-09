<?php
declare(strict_types = 1);

namespace Test\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\ContentLocationFactory,
    Header\ContentLocation
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class ContentLocationFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new ContentLocationFactory
        );
    }

    public function testMake()
    {
        $header = (new ContentLocationFactory)(
            new Str('Content-Location'),
            new Str('http://example.com')
        );

        $this->assertInstanceOf(ContentLocation::class, $header);
        $this->assertSame('Content-Location: http://example.com/', $header->toString());
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new ContentLocationFactory)(
            new Str('foo'),
            new Str('')
        );
    }
}
