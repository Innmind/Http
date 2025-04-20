<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header\Cookie,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class CookieFactoryTest extends TestCase
{
    public function testMake()
    {
        $header = Factory::new(Clock::live())(
            Str::of('Cookie'),
            Str::of('foo=bar;bar=baz; baz="foo"'),
        );

        $this->assertInstanceOf(Cookie::class, $header);
        $this->assertSame('Cookie: foo=bar; bar=baz; baz=foo', $header->normalize()->toString());
        $this->assertSame(
            'Cookie: ',
            Factory::new(Clock::live())(Str::of('Cookie'), Str::of(''))->normalize()->toString(),
        );
    }
}
