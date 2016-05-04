<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Factory\Header;

use Innmind\Http\{
    Factory\Header\DateFactory,
    Factory\HeaderFactoryInterface,
    Header\Date
};
use Innmind\Immutable\StringPrimitive as Str;

class DateFactoryTest extends \PHPUnit_Framework_TestCase
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
}
