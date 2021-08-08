<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\ExpiresFactory,
    Factory\HeaderFactory,
    Header\Expires,
    Exception\DomainException,
};
use Innmind\TimeContinuum\Earth\Clock;
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class ExpiresFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new ExpiresFactory(new Clock)
        );
    }

    public function testMake()
    {
        $header = (new ExpiresFactory(new Clock))(
            Str::of('Expires'),
            Str::of('Tue, 15 Nov 1994 08:12:31 GMT'),
        );

        $this->assertInstanceOf(Expires::class, $header);
        $this->assertSame(
            'Expires: Tue, 15 Nov 1994 08:12:31 GMT',
            $header->toString(),
        );
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new ExpiresFactory(new Clock))(
            Str::of('foo'),
            Str::of(''),
        );
    }

    public function testThrowWhenNotOfExpectedFormat()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Expires');

        (new ExpiresFactory(new Clock))(
            Str::of('Expires'),
            Str::of('2020-01-01'),
        );
    }
}
