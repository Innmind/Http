<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\DateFactory,
    Factory\HeaderFactory,
    Header\Date,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class DateFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new DateFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('Date'),
            Str::of('Tue, 15 Nov 1994 08:12:31 GMT'),
        );

        $this->assertInstanceOf(Date::class, $h);
        $this->assertSame(
            'Date: Tue, 15 Nov 1994 08:12:31 GMT',
            $h->toString(),
        );
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new DateFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }

    public function testThrowWhenNotOFExpectedFormat()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Date');

        (new DateFactory)(
            Str::of('Date'),
            Str::of('2020-01-01'),
        );
    }
}
