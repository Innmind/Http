<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\ReferrerFactory,
    Factory\HeaderFactoryInterface,
    Header\Referrer
};
use Innmind\Immutable\StringPrimitive as Str;
use PHPUnit\Framework\TestCase;

class ReferrerFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new ReferrerFactory;

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

        $h = $f->make(
            new Str('Referer'),
            new Str('http://www.w3.org/hypertext/DataSources/Overview.html')
        );

        $this->assertInstanceOf(Referrer::class, $h);
        $this->assertSame(
            'Referer : http://www.w3.org/hypertext/DataSources/Overview.html',
            (string) $h
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new ReferrerFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}
