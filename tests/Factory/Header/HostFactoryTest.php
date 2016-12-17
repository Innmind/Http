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
    /**
     * @dataProvider cases
     */
    public function testMake(string $host)
    {
        $f = new HostFactory;

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

        $h = $f->make(
            new Str('Host'),
            new Str($host)
        );

        $this->assertInstanceOf(Host::class, $h);
        $this->assertSame(
            'Host : '.$host,
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

    public function cases(): array
    {
        return [
            ['www.w3.org:8080'],
            ['www.w3.org'],
            ['localhost'],
            ['127.0.0.1'],
        ];
    }
}
