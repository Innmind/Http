<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\HostFactory,
    Factory\HeaderFactoryInterface,
    Header\Host
};
use Innmind\Immutable\StringPrimitive as Str;

class HostFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new HostFactory;

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

        $h = $f->make(
            new Str('Host'),
            new Str('www.w3.org:8080')
        );

        $this->assertInstanceOf(Host::class, $h);
        $this->assertSame(
            'Host : www.w3.org:8080',
            (string) $h
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new HostFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}
