<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptFactory,
    Factory\HeaderFactoryInterface,
    Header\Accept
};
use Innmind\Immutable\StringPrimitive as Str;
use PHPUnit\Framework\TestCase;

class AcceptFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new AcceptFactory;

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

        $h = $f->make(
            new Str('Accept'),
            new Str('audio/*; q=0.2; level="1", audio/basic')
        );

        $this->assertInstanceOf(Accept::class, $h);
        $this->assertSame('Accept : audio/*;q=0.2;level=1, audio/basic', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new AcceptFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotValid()
    {
        (new AcceptFactory)->make(
            new Str('Accept'),
            new Str('@')
        );
    }
}
