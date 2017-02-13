<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\DateFactory,
    Factory\HeaderFactoryInterface,
    Header\Date
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class DateFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new DateFactory;

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

        $h = $f->make(
            new Str('Date'),
            new Str('Tue, 15 Nov 1994 08:12:31 GMT')
        );

        $this->assertInstanceOf(Date::class, $h);
        $this->assertSame(
            'Date : Tue, 15 Nov 1994 08:12:31 +0000',
            (string) $h
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new DateFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}
