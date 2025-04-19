<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Referrer,
    Header,
};
use Innmind\Immutable\Sequence;
use Innmind\Url\Url;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ReferrerTest extends TestCase
{
    public function testInterface()
    {
        $h = Referrer::of(
            Url::of('/foo/bar'),
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Referer', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Sequence::class, $v);
        $this->assertSame('Referer: /foo/bar', $h->toString());
        $this->assertSame('/foo/bar', $h->referrer()->toString());
    }

    public function testOf()
    {
        $header = Referrer::of(Url::of('/foo/bar'));

        $this->assertInstanceOf(Referrer::class, $header);
        $this->assertSame('Referer: /foo/bar', $header->toString());
    }
}
