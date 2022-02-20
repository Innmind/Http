<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Referrer,
    Header,
    Header\Value,
    Header\ReferrerValue
};
use Innmind\Immutable\Set;
use Innmind\Url\Url;
use PHPUnit\Framework\TestCase;

class ReferrerTest extends TestCase
{
    public function testInterface()
    {
        $h = new Referrer(
            $av = new ReferrerValue(Url::of('/foo/bar')),
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Referer', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Set::class, $v);
        $this->assertSame($av, $v->find(static fn() => true)->match(
            static fn($first) => $first,
            static fn() => null,
        ));
        $this->assertSame('Referer: /foo/bar', $h->toString());
    }

    public function testOf()
    {
        $header = Referrer::of(Url::of('/foo/bar'));

        $this->assertInstanceOf(Referrer::class, $header);
        $this->assertSame('Referer: /foo/bar', $header->toString());
    }
}
