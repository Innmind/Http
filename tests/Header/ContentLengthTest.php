<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentLength,
    Header,
    Header\ContentLengthValue
};
use Innmind\Immutable\Sequence;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentLengthTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentLength(
            $av = new ContentLengthValue(42),
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Content-Length', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Sequence::class, $v);
        $this->assertSame($av, $v->find(static fn() => true)->match(
            static fn($first) => $first,
            static fn() => null,
        ));
        $this->assertSame('Content-Length: 42', $h->toString());
        $this->assertSame(42, $h->length());
    }

    public function testOf()
    {
        $header = ContentLength::of(42);

        $this->assertInstanceOf(ContentLength::class, $header);
        $this->assertSame('Content-Length: 42', $header->toString());
    }
}
