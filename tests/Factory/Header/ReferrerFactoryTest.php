<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\ReferrerFactory,
    Factory\HeaderFactory,
    Header\Referrer,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class ReferrerFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new ReferrerFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('Referer'),
            Str::of('http://www.w3.org/hypertext/DataSources/Overview.html'),
        );

        $this->assertInstanceOf(Referrer::class, $h);
        $this->assertSame(
            'Referer: http://www.w3.org/hypertext/DataSources/Overview.html',
            $h->toString(),
        );
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new ReferrerFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }
}
