<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\ReferrerFactory,
    Header\Referrer,
};
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ReferrerFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new ReferrerFactory;

        $h = ($f)(
            Str::of('Referer'),
            Str::of('http://www.w3.org/hypertext/DataSources/Overview.html'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(Referrer::class, $h);
        $this->assertSame(
            'Referer: http://www.w3.org/hypertext/DataSources/Overview.html',
            $h->toString(),
        );
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new ReferrerFactory)(Str::of('foo'), Str::of(''))->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
