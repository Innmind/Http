<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\IfUnmodifiedSinceFactory,
    Factory\HeaderFactory,
    Header\IfUnmodifiedSince,
    Exception\DomainException,
};
use Innmind\TimeContinuum\Earth\Clock;
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class IfUnmodifiedSinceFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new IfUnmodifiedSinceFactory(new Clock);

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('If-Unmodified-Since'),
            Str::of('Tue, 15 Nov 1994 08:12:31 GMT'),
        );

        $this->assertInstanceOf(IfUnmodifiedSince::class, $h);
        $this->assertSame(
            'If-Unmodified-Since: Tue, 15 Nov 1994 08:12:31 GMT',
            $h->toString(),
        );
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new IfUnmodifiedSinceFactory(new Clock))(
            Str::of('foo'),
            Str::of(''),
        );
    }

    public function testThrowWhenNotOfExpectedFormat()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('If-Unmodified-Since');

        (new IfUnmodifiedSinceFactory(new Clock))(
            Str::of('If-Unmodified-Since'),
            Str::of('2020-01-01'),
        );
    }
}
