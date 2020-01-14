<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptFactory,
    Factory\HeaderFactory,
    Header\Accept,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class AcceptFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new AcceptFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('Accept'),
            Str::of('audio/*; q=0.2; level="1", audio/basic'),
        );

        $this->assertInstanceOf(Accept::class, $h);
        $this->assertSame('Accept: audio/*;q=0.2;level=1, audio/basic', $h->toString());
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new AcceptFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }

    public function testThrowWhenNotValid()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('@');

        (new AcceptFactory)(
            Str::of('Accept'),
            Str::of('@'),
        );
    }
}
